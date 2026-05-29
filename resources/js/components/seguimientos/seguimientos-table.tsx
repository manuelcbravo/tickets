import { Pencil, Trash2 } from 'lucide-react';
import {
    SEGUIMIENTO_ESTADO_LABELS,
    SEGUIMIENTO_PRIORIDAD_LABELS,
} from '@/components/seguimientos/options';
import type { Seguimiento } from '@/components/seguimientos/types';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

type SeguimientosTableProps = {
    items: Seguimiento[];
    deletingId: number | null;
    onEdit: (item: Seguimiento) => void;
    onDelete: (item: Seguimiento) => void;
};

const formatDate = (value: string | null) =>
    value ? new Date(value).toLocaleDateString('es-MX') : 'Sin fecha';

export function SeguimientosTable({
    items,
    deletingId,
    onEdit,
    onDelete,
}: SeguimientosTableProps) {
    if (items.length === 0) {
        return (
            <p className="rounded-lg border p-6 text-sm text-muted-foreground">
                No hay seguimientos registrados para este elemento.
            </p>
        );
    }

    return (
        <div className="overflow-hidden rounded-lg border">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Titulo</TableHead>
                        <TableHead>Tipo</TableHead>
                        <TableHead>Fecha</TableHead>
                        <TableHead>Estado</TableHead>
                        <TableHead>Prioridad</TableHead>
                        <TableHead />
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {items.map((item) => (
                        <TableRow key={item.id}>
                            <TableCell>
                                <div className="space-y-1">
                                    <p className="font-medium">{item.titulo}</p>
                                    <p className="text-xs text-muted-foreground line-clamp-2">
                                        {item.seguimiento}
                                    </p>
                                </div>
                            </TableCell>
                            <TableCell>{item.tipo?.nombre ?? 'Sin tipo'}</TableCell>
                            <TableCell>{formatDate(item.fecha_seguimiento)}</TableCell>
                            <TableCell>
                                {item.estado ? (SEGUIMIENTO_ESTADO_LABELS[item.estado] ?? item.estado) : '-'}
                            </TableCell>
                            <TableCell>
                                {item.prioridad
                                    ? (SEGUIMIENTO_PRIORIDAD_LABELS[item.prioridad] ?? item.prioridad)
                                    : '-'}
                            </TableCell>
                            <TableCell>
                                <div className="flex justify-end gap-1">
                                    <Button
                                        type="button"
                                        size="icon"
                                        variant="ghost"
                                        className="size-8"
                                        onClick={() => onEdit(item)}
                                    >
                                        <Pencil className="size-4" />
                                    </Button>
                                    <Button
                                        type="button"
                                        size="icon"
                                        variant="ghost"
                                        className="size-8 text-destructive"
                                        onClick={() => onDelete(item)}
                                        disabled={deletingId === item.id}
                                    >
                                        <Trash2 className="size-4" />
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </div>
    );
}
