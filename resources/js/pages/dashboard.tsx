import React from 'react';
import AppLayout from '@/components/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface Stats {
    total_books: number;
    available_books: number;
    total_members: number;
    borrowed_books: number;
    overdue_books: number;
}

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
    borrowed_date: string;
    due_date: string;
    status: string;
}

interface Props {
    stats: Stats;
    recent_transactions: Transaction[];
    [key: string]: unknown;
}

export default function Dashboard({ stats, recent_transactions }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard - Library Management System" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                {/* Stats Cards */}
                <div className="grid auto-rows-min gap-4 md:grid-cols-5">
                    <div className="bg-white p-6 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Buku</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_books}</p>
                            </div>
                            <div className="p-3 bg-blue-100 rounded-full dark:bg-blue-900">
                                <span className="text-2xl">📚</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Buku Tersedia</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.available_books}</p>
                            </div>
                            <div className="p-3 bg-green-100 rounded-full dark:bg-green-900">
                                <span className="text-2xl">✅</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Anggota</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_members}</p>
                            </div>
                            <div className="p-3 bg-purple-100 rounded-full dark:bg-purple-900">
                                <span className="text-2xl">👥</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Buku Dipinjam</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.borrowed_books}</p>
                            </div>
                            <div className="p-3 bg-orange-100 rounded-full dark:bg-orange-900">
                                <span className="text-2xl">📤</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Terlambat</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.overdue_books}</p>
                            </div>
                            <div className="p-3 bg-red-100 rounded-full dark:bg-red-900">
                                <span className="text-2xl">⚠️</span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Recent Transactions */}
                <div className="bg-white rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                            📋 Transaksi Terbaru
                        </h2>
                        <p className="text-sm text-gray-600 dark:text-gray-400">
                            10 transaksi peminjaman terbaru
                        </p>
                    </div>
                    
                    <div className="p-6">
                        {recent_transactions && recent_transactions.length > 0 ? (
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {recent_transactions.map((transaction) => (
                                            <tr key={transaction.id} className="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td className="py-3 font-medium text-gray-900 dark:text-white">
                                                    {transaction.transaction_code}
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    <div>
                                                        <div className="font-medium">{transaction.member.name}</div>
                                                        <div className="text-xs text-gray-500">{transaction.member.member_code}</div>
                                                    </div>
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    <div>
                                                        <div className="font-medium">{transaction.book.title}</div>
                                                        <div className="text-xs text-gray-500">{transaction.book.barcode}</div>
                                                    </div>
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    {new Date(transaction.borrowed_date).toLocaleDateString('id-ID')}
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    {new Date(transaction.due_date).toLocaleDateString('id-ID')}
                                                </td>
                                                <td className="py-3">
                                                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                        transaction.status === 'borrowed' 
                                                            ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' 
                                                            : transaction.status === 'overdue'
                                                            ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                                            : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                    }`}>
                                                        {transaction.status === 'borrowed' ? '📤 Dipinjam' :
                                                         transaction.status === 'overdue' ? '⚠️ Terlambat' : '✅ Dikembalikan'}
                                                    </span>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        ) : (
                            <div className="text-center py-12 text-gray-500 dark:text-gray-400">
                                <span className="text-4xl mb-4 block">📋</span>
                                <p>Belum ada transaksi</p>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}