import React from 'react';
import AppLayout from '@/components/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Transaksi',
        href: '/transactions',
    },
];

interface Transaction {
    id: number;
    transaction_code: string;
    member: {
        name: string;
        member_code: string;
    };
    book: {
        title: string;
        barcode: string;
    };
    borrowed_by: {
        name: string;
    };
    returned_by?: {
        name: string;
    };
    borrowed_date: string;
    due_date: string;
    returned_date?: string;
    status: string;
    fine_amount: number;
    fine_paid: boolean;
}

interface Props {
    transactions: {
        data: Transaction[];
        links: unknown[];
        meta: {
            total: number;
        };
    };
    filters: {
        search?: string;
        status?: string;
    };
    [key: string]: unknown;
}

export default function TransactionsIndex({ transactions }: Props) {
    const getStatusBadge = (status: string) => {
        const badges = {
            borrowed: 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            returned: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            overdue: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        };
        return badges[status as keyof typeof badges] || badges.borrowed;
    };

    const getStatusText = (status: string) => {
        const texts = {
            borrowed: '📤 Dipinjam',
            returned: '✅ Dikembalikan',
            overdue: '⚠️ Terlambat',
        };
        return texts[status as keyof typeof texts] || 'Dipinjam';
    };

    const isOverdue = (dueDate: string, status: string) => {
        return status === 'borrowed' && new Date(dueDate) < new Date();
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Transaksi - Library Management System" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                            🔄 Transaksi Perpustakaan
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Kelola peminjaman dan pengembalian buku
                        </p>
                    </div>
                    <Link href="/transactions/create">
                        <Button>
                            ➕ Pinjam Buku
                        </Button>
                    </Link>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-blue-600">{transactions.meta?.total || 0}</div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Total Transaksi</div>
                    </div>
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-orange-600">
                            {transactions.data?.filter(t => t.status === 'borrowed').length || 0}
                        </div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Sedang Dipinjam</div>
                    </div>
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-red-600">
                            {transactions.data?.filter(t => isOverdue(t.due_date, t.status)).length || 0}
                        </div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Terlambat</div>
                    </div>
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-green-600">
                            {transactions.data?.filter(t => t.status === 'returned').length || 0}
                        </div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Dikembalikan</div>
                    </div>
                </div>

                {/* Transactions Table */}
                <div className="bg-white rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 className="text-lg font-semibold text-gray-900 dark:text-white">
                            Daftar Transaksi
                        </h2>
                    </div>
                    
                    <div className="p-6">
                        {transactions.data && transactions.data.length > 0 ? (
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm">
                                    <thead>
                                        <tr className="border-b border-gray-200 dark:border-gray-700">
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Kode Transaksi
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Anggota
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Buku
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Tanggal Pinjam
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Jatuh Tempo
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Status
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Denda
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {transactions.data.map((transaction) => (
                                            <tr key={transaction.id} className="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td className="py-3">
                                                    <div className="font-medium text-gray-900 dark:text-white">
                                                        {transaction.transaction_code}
                                                    </div>
                                                </td>
                                                <td className="py-3">
                                                    <div>
                                                        <div className="font-medium text-gray-900 dark:text-white">
                                                            {transaction.member.name}
                                                        </div>
                                                        <div className="text-xs text-gray-500">
                                                            {transaction.member.member_code}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="py-3">
                                                    <div>
                                                        <div className="font-medium text-gray-900 dark:text-white">
                                                            {transaction.book.title}
                                                        </div>
                                                        <div className="text-xs text-gray-500">
                                                            {transaction.book.barcode}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    {new Date(transaction.borrowed_date).toLocaleDateString('id-ID')}
                                                </td>
                                                <td className="py-3">
                                                    <div className={
                                                        isOverdue(transaction.due_date, transaction.status)
                                                            ? 'text-red-600 font-medium'
                                                            : 'text-gray-600 dark:text-gray-300'
                                                    }>
                                                        {new Date(transaction.due_date).toLocaleDateString('id-ID')}
                                                        {isOverdue(transaction.due_date, transaction.status) && (
                                                            <div className="text-xs text-red-500">
                                                                {Math.ceil((new Date().getTime() - new Date(transaction.due_date).getTime()) / (1000 * 60 * 60 * 24))} hari
                                                            </div>
                                                        )}
                                                    </div>
                                                </td>
                                                <td className="py-3">
                                                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                        isOverdue(transaction.due_date, transaction.status)
                                                            ? getStatusBadge('overdue')
                                                            : getStatusBadge(transaction.status)
                                                    }`}>
                                                        {isOverdue(transaction.due_date, transaction.status) 
                                                            ? getStatusText('overdue')
                                                            : getStatusText(transaction.status)
                                                        }
                                                    </span>
                                                </td>
                                                <td className="py-3">
                                                    {transaction.fine_amount > 0 ? (
                                                        <div>
                                                            <div className="text-red-600 font-medium">
                                                                Rp {transaction.fine_amount.toLocaleString('id-ID')}
                                                            </div>
                                                            <div className={`text-xs ${
                                                                transaction.fine_paid 
                                                                    ? 'text-green-600' 
                                                                    : 'text-red-500'
                                                            }`}>
                                                                {transaction.fine_paid ? 'Lunas' : 'Belum Bayar'}
                                                            </div>
                                                        </div>
                                                    ) : (
                                                        <span className="text-gray-400">-</span>
                                                    )}
                                                </td>
                                                <td className="py-3">
                                                    <div className="flex items-center gap-2">
                                                        <Link href={`/transactions/${transaction.id}`}>
                                                            <Button variant="outline" size="sm">
                                                                👁️ Lihat
                                                            </Button>
                                                        </Link>
                                                        {transaction.status === 'borrowed' && (
                                                            <Link href={`/transactions/${transaction.id}/edit`}>
                                                                <Button variant="outline" size="sm">
                                                                    📥 Kembalikan
                                                                </Button>
                                                            </Link>
                                                        )}
                                                    </div>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        ) : (
                            <div className="text-center py-12 text-gray-500 dark:text-gray-400">
                                <span className="text-4xl mb-4 block">🔄</span>
                                <p>Belum ada transaksi</p>
                                <Link href="/transactions/create" className="mt-4 inline-block">
                                    <Button>Mulai Transaksi Pertama</Button>
                                </Link>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}