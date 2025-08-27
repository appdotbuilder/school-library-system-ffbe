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
        title: 'Manajemen Anggota',
        href: '/members',
    },
];

interface Member {
    id: number;
    member_code: string;
    barcode: string;
    nisn_nip: string | null;
    name: string;
    email: string | null;
    phone: string | null;
    member_type: string;
    status: string;
    joined_date: string;
    school_class: {
        name: string;
    } | null;
    major: {
        name: string;
        code: string;
    } | null;
}

interface Props {
    members: {
        data: Member[];
        links: unknown[];
        meta: {
            total: number;
        };
    };
    classes: Array<{id: number; name: string}>;
    majors: Array<{id: number; name: string; code: string}>;
    filters: {
        search?: string;
        status?: string;
        member_type?: string;
        class_id?: string;
    };
    [key: string]: unknown;
}

export default function MembersIndex({ members }: Props) {
    const getStatusBadge = (status: string) => {
        const badges = {
            active: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            inactive: 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            suspended: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        };
        return badges[status as keyof typeof badges] || badges.active;
    };

    const getTypeBadge = (type: string) => {
        const badges = {
            student: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            teacher: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            staff: 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
        };
        return badges[type as keyof typeof badges] || badges.student;
    };

    const getTypeText = (type: string) => {
        const texts = {
            student: '🎓 Siswa',
            teacher: '👨‍🏫 Guru',
            staff: '👨‍💼 Staff',
        };
        return texts[type as keyof typeof texts] || 'Siswa';
    };

    const getStatusText = (status: string) => {
        const texts = {
            active: '✅ Aktif',
            inactive: '⚫ Tidak Aktif',
            suspended: '🚫 Dinonaktifkan',
        };
        return texts[status as keyof typeof texts] || 'Aktif';
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Manajemen Anggota - Library Management System" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                            👥 Manajemen Anggota
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Kelola data anggota perpustakaan
                        </p>
                    </div>
                    <Link href="/members/create">
                        <Button>
                            ➕ Tambah Anggota
                        </Button>
                    </Link>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-blue-600">{members.meta?.total || 0}</div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Total Anggota</div>
                    </div>
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-green-600">
                            {members.data?.filter(m => m.status === 'active').length || 0}
                        </div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Anggota Aktif</div>
                    </div>
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-purple-600">
                            {members.data?.filter(m => m.member_type === 'student').length || 0}
                        </div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Siswa</div>
                    </div>
                    <div className="bg-white p-4 rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <div className="text-2xl font-bold text-orange-600">
                            {members.data?.filter(m => m.member_type === 'teacher' || m.member_type === 'staff').length || 0}
                        </div>
                        <div className="text-sm text-gray-600 dark:text-gray-400">Guru/Staff</div>
                    </div>
                </div>

                {/* Members Table */}
                <div className="bg-white rounded-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div className="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 className="text-lg font-semibold text-gray-900 dark:text-white">
                            Daftar Anggota
                        </h2>
                    </div>
                    
                    <div className="p-6">
                        {members.data && members.data.length > 0 ? (
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm">
                                    <thead>
                                        <tr className="border-b border-gray-200 dark:border-gray-700">
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Nama Anggota
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                NISN/NIP
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Tipe
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Kelas/Jurusan
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Status
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Bergabung
                                            </th>
                                            <th className="text-left py-3 font-medium text-gray-600 dark:text-gray-400">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {members.data.map((member) => (
                                            <tr key={member.id} className="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td className="py-3">
                                                    <div>
                                                        <div className="font-medium text-gray-900 dark:text-white">
                                                            {member.name}
                                                        </div>
                                                        <div className="text-xs text-gray-500">
                                                            {member.member_code} • {member.barcode}
                                                        </div>
                                                        {member.email && (
                                                            <div className="text-xs text-gray-500">
                                                                {member.email}
                                                            </div>
                                                        )}
                                                    </div>
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    {member.nisn_nip || '-'}
                                                </td>
                                                <td className="py-3">
                                                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${getTypeBadge(member.member_type)}`}>
                                                        {getTypeText(member.member_type)}
                                                    </span>
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    <div>
                                                        {member.school_class && (
                                                            <div>Kelas {member.school_class.name}</div>
                                                        )}
                                                        {member.major && (
                                                            <div className="text-xs text-gray-500">
                                                                {member.major.code}
                                                            </div>
                                                        )}
                                                        {!member.school_class && !member.major && '-'}
                                                    </div>
                                                </td>
                                                <td className="py-3">
                                                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${getStatusBadge(member.status)}`}>
                                                        {getStatusText(member.status)}
                                                    </span>
                                                </td>
                                                <td className="py-3 text-gray-600 dark:text-gray-300">
                                                    {new Date(member.joined_date).toLocaleDateString('id-ID')}
                                                </td>
                                                <td className="py-3">
                                                    <div className="flex items-center gap-2">
                                                        <Link href={`/members/${member.id}`}>
                                                            <Button variant="outline" size="sm">
                                                                👁️ Lihat
                                                            </Button>
                                                        </Link>
                                                        <Link href={`/members/${member.id}/edit`}>
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
                                <span className="text-4xl mb-4 block">👥</span>
                                <p>Belum ada anggota yang terdaftar</p>
                                <Link href="/members/create" className="mt-4 inline-block">
                                    <Button>Tambah Anggota Pertama</Button>
                                </Link>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}