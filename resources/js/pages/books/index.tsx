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
        title: 'Manajemen Buku',
        href: '/books',
    },
];

interface Book {
    id: number;
    title: string;
    isbn: string | null;
    barcode: string;
    publication_year: number;
    quantity: number;
    available_quantity: number;
    author: {
        name: string;
    };
    category: {
        name: string;
    };
    book_shelf: {
        name: string;
        code: string;
    };
    publisher: {
        name: string;
    };
}

interface Props {
    books: {
        data: Book[];
        links: unknown[];
        meta: {
            total: number;
        };
    };
    categories: Array<{id: number; name: string}>;
    shelves: Array<{id: number; name: string; code: string}>;
    filters: {
        search?: string;
        category_id?: string;
        shelf_id?: string;
    };
    [key: string]: unknown;
}

export default function BooksIndex({ books, categories, shelves }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Manajemen Buku - Library Management System" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                            📚 Manajemen Buku
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Kelola koleksi buku perpustakaan
                        </p>
                    </div>
                    <Link href="/books/create">
                        <Button>
                            ➕ Tambah Buku
                        </Button>
                    </Link>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-blue-600">{books.meta?.total || 0}</div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Total Buku</div>
                    </div>
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-green-600">
                            {books.data?.reduce((sum, book) => sum + book.available_quantity, 0) || 0}
                        </div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Buku Tersedia</div>
                    </div>
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-purple-600">{categories?.length || 0}</div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Kategori</div>
                    </div>
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-orange-600">{shelves?.length || 0}</div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Rak Buku</div>
                    </div>
                </div>

                {/* Books Table */}
                <div className="bg-white rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 className="text-lg font-semibold text-gray-900 dark:text-white">
                            Daftar Buku
                        </h2>
                    </div>
                    
                    <div className="p-6">
                        {books.data && books.data.length > 0 ? (
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm">
                                    <thead>
                                        <tr className="border-b border-gray-200 dark:border-gray-700">
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Judul Buku
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Penulis
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Kategori
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Rak
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Stok
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Tersedia
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {books.data.map((book) => (
                                            <tr key={book.id} className="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td className="py-3">
                                                    <div>
                                                        <div className="font-medium text-gray-900 dark:text-white">
                                                            {book.title}
                                                        </div>
                                                        <div className="text-xs text-gray-500">
                                                            {book.barcode} • {book.publication_year}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    {book.author.name}
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    {book.category.name}
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    {book.book_shelf.code}
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    {book.quantity}
                                                </td>
                                                <td className="py-3">
                                                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                        book.available_quantity > 0
                                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                                    }`}>
                                                        {book.available_quantity}
                                                    </span>
                                                </td>
                                                <td className="py-3">
                                                    <div className="flex items-center gap-2">
                                                        <Link href={`/books/${book.id}`}>
                                                            <Button variant="outline" size="sm">
                                                                👁️ Lihat
                                                            </Button>
                                                        </Link>
                                                        <Link href={`/books/${book.id}/edit`}>
                                                            <Button variant="outline" size="sm">
                                                                ✏️ Edit
                                                            </Button>
                                                        </Link>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        ) : (
                            <div className="text-center py-12 text-gray-500 dark:text-gray-400">
                                <span className="text-4xl mb-4 block">📚</span>
                                <p>Belum ada buku yang terdaftar</p>
                                <Link href="/books/create" className="mt-4 inline-block">
                                    <Button>Tambah Buku Pertama</Button>
                                </Link>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}