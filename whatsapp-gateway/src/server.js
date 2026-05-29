import "dotenv/config"

import express from "express"
import cors from "cors"
import QRCode from "qrcode"

import {
    startWhatsApp,
    sendMessage,
    getQR,
    getConnectionStatus,
    connectWhatsApp,
    reconnectWhatsApp,
    disconnectWhatsApp
} from "./whatsapp.js"

const app = express()

app.use(cors())
app.use(express.json())

app.get("/", (_req, res) => {
    res.json({ status: "WhatsApp gateway activo" })
})

app.get("/qr", async (_req, res) => {

    const qr = getQR()

    if (!qr) {
        return res
            .type("html")
            .send(`<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WhatsApp QR</title>
</head>
<body>
    <h2>WhatsApp ya esta conectado</h2>
</body>
</html>`)
    }

    const image = await QRCode.toDataURL(qr)

    res
        .type("html")
        .send(`<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WhatsApp QR</title>
</head>
<body>
    <img src="${image}" alt="QR de WhatsApp" />
</body>
</html>`)

})

app.get("/status", (_req, res) => {

    const connected = getConnectionStatus()
    const hasQR = Boolean(getQR())

    res.json({
        ok: true,
        connected,
        has_qr: hasQR
    })

})

app.get("/qr-json", async (_req, res) => {

    const qr = getQR()

    if (!qr) {
        return res.json({
            ok: true,
            available: false,
            qr: null
        })
    }

    const image = await QRCode.toDataURL(qr)

    res.json({
        ok: true,
        available: true,
        qr: image
    })

})

app.post("/connect", async (_req, res) => {

    try {
        await connectWhatsApp()

        res.json({
            ok: true,
            message: "Proceso de conexión iniciado"
        })
    } catch (error) {
        res.status(500).json({
            ok: false,
            message: error.message
        })
    }

})

app.post("/disconnect", async (_req, res) => {

    try {
        await disconnectWhatsApp()

        res.json({
            ok: true,
            message: "Desconexión ejecutada"
        })
    } catch (error) {
        res.status(500).json({
            ok: false,
            message: error.message
        })
    }

})

app.post("/reconnect", async (_req, res) => {

    try {
        await reconnectWhatsApp()

        res.json({
            ok: true,
            connected: getConnectionStatus()
        })
    } catch (error) {
        res.status(500).json({
            ok: false,
            connected: false,
            message: error.message
        })
    }

})

app.post("/send", async (req, res) => {

    const { phone, message } = req.body

    try {

        const result = await sendMessage(phone, message)

        res.json({
            success: true,
            result
        })

    } catch (error) {

        res.status(500).json({
            error: error.message
        })

    }

})

const PORT = process.env.PORT || 3001

app.listen(PORT, async () => {

    console.log("WhatsApp Gateway iniciado")

    await startWhatsApp()

})
