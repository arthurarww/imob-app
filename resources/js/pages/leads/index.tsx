import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { DataTable } from './data-table';
import { columns } from './data-table/columns';
import DialogStoreLead from './dialog-store-lead';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Leads',
        href: '#',
    },
];

export default function LeadsIndex() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Leads" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex justify-end">
                    <DialogStoreLead />
                </div>
                <DataTable columns={columns} data={[]} />
            </div>
        </AppLayout>
    );
}
