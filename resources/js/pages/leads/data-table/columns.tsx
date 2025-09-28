'use client';

import { ColumnDef } from '@tanstack/react-table';

export type Lead = {
    id: string;
    name: string;
    email: string;
    phone: string;
    status: 'pending' | 'processing' | 'success' | 'failed';
};

export const columns: ColumnDef<Lead>[] = [
    {
        accessorKey: 'name',
        header: 'Name',
    },
    {
        accessorKey: 'status',
        header: 'Status',
    },
    {
        accessorKey: 'phone',
        header: 'Phone',
    },
    {
        accessorKey: 'email',
        header: 'Email',
    },
];
