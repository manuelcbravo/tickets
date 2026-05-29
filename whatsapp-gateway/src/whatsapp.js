import makeWASocket, {
    DisconnectReason,
    fetchLatestBaileysVersion,
    useMultiFileAuthState
} from "@whiskeysockets/baileys"
import pino from "pino"

let sock = null
let qrCode = null
let isConnected = false
let reconnectTimer = null
let startInProgress = false
let suppressReconnect = false

function getDisconnectReason(update) {
    const statusCode = update?.lastDisconnect?.error?.output?.statusCode

    if (typeof statusCode !== "number") {
        return { statusCode: null, reasonText: "desconocido" }
    }

    const reasonByCode = Object.entries(DisconnectReason).find(([, value]) => value === statusCode)?.[0]

    return {
        statusCode,
        reasonText: reasonByCode ?? "desconocido"
    }
}

export async function startWhatsApp() {

    if (startInProgress) {
        return
    }

    startInProgress = true

    try {

        const { state, saveCreds } = await useMultiFileAuthState("auth")
        const { version } = await fetchLatestBaileysVersion()

        sock = makeWASocket({
            version,
            auth: state,
            logger: pino({ level: "silent" })
        })

        sock.ev.on("creds.update", saveCreds)

        sock.ev.on("connection.update", (update) => {

            const { connection, qr } = update

            if (qr) {
                qrCode = qr
                console.log("QR disponible, escanealo en /qr")
            }

            if (connection === "open") {
                console.log("WhatsApp conectado")
                isConnected = true
                suppressReconnect = false
                qrCode = null

                if (reconnectTimer) {
                    clearTimeout(reconnectTimer)
                    reconnectTimer = null
                }
            }

            if (connection === "close") {
                isConnected = false
                sock = null
                const { statusCode, reasonText } = getDisconnectReason(update)
                const reasonMessage = statusCode
                    ? `${reasonText} (${statusCode})`
                    : reasonText

                console.log(`WhatsApp desconectado. Motivo: ${reasonMessage}`)

                if (suppressReconnect) {
                    console.log("Reconexión automática omitida por desconexión manual.")
                    return
                }

                if (statusCode === DisconnectReason.loggedOut) {
                    console.log("Sesion cerrada (loggedOut). No se intentara reconectar automaticamente.")
                    return
                }

                if (!reconnectTimer) {
                    reconnectTimer = setTimeout(() => {
                        reconnectTimer = null
                        startWhatsApp().catch((error) => {
                            console.error("Error al reconectar WhatsApp:", error)
                        })
                    }, 3000)
                }
            }

        })

    } finally {
        startInProgress = false
    }

}

export async function sendMessage(phone, message) {

    if (!sock) throw new Error("WhatsApp no inicializado")

    const jid = `${phone}@s.whatsapp.net`

    return sock.sendMessage(jid, { text: message })
}

export function getQR() {
    return qrCode
}

export function getConnectionStatus() {
    return isConnected
}

export async function connectWhatsApp() {
    suppressReconnect = false
    await startWhatsApp()
}

export async function reconnectWhatsApp() {
    suppressReconnect = false
    isConnected = false
    qrCode = null

    if (reconnectTimer) {
        clearTimeout(reconnectTimer)
        reconnectTimer = null
    }

    if (sock) {
        try {
            sock.ws?.close()
        } catch (error) {
            console.warn("No se pudo cerrar la conexion para reconectar:", error?.message ?? error)
        } finally {
            sock = null
        }
    }

    await startWhatsApp()
}

export async function disconnectWhatsApp() {
    suppressReconnect = true
    isConnected = false
    qrCode = null

    if (reconnectTimer) {
        clearTimeout(reconnectTimer)
        reconnectTimer = null
    }

    if (!sock) return

    try {
        // Cierra la conexión activa sin cerrar sesión en WhatsApp,
        // para no tocar ni invalidar el estado persistido en /auth.
        sock.ws?.close()
    } catch (error) {
        console.warn("No se pudo cerrar la conexión manualmente:", error?.message ?? error)
    } finally {
        sock = null
    }
}
