import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import type { MouseEventHandler } from 'react';

type LoadingSubmitButtonProps = {
    label: string;
    processing: boolean;
    className?: string;
    type?: 'button' | 'submit' | 'reset';
    onClick?: MouseEventHandler<HTMLButtonElement>;
};

export function LoadingSubmitButton({ label, processing, className, type = 'submit', onClick }: LoadingSubmitButtonProps) {
    return (
        <Button type={type} onClick={onClick} disabled={processing} className={className} aria-busy={processing}>
            {processing && <Spinner className="mr-2 size-4" />}
            {label}
        </Button>
    );
}
