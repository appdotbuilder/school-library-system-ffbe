<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookShelf;
use App\Models\Category;
use App\Models\Major;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Role;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Full access to all system features',
            'permissions' => [
                'manage_users', 'manage_roles', 'manage_books', 'manage_members',
                'manage_transactions', 'view_reports', 'manage_settings'
            ],
        ]);

        $librarianRole = Role::create([
            'name' => 'librarian',
            'display_name' => 'Petugas Perpustakaan',
            'description' => 'Manage library operations',
            'permissions' => [
                'manage_books', 'manage_members', 'manage_transactions'
            ],
        ]);

        $headmasterRole = Role::create([
            'name' => 'headmaster',
            'display_name' => 'Kepala Sekolah',
            'description' => 'View reports and statistics',
            'permissions' => [
                'view_reports', 'view_statistics'
            ],
        ]);

        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
            'employee_id' => 'ADM001',
        ]);

        // Create librarian user
        User::create([
            'name' => 'Librarian User',
            'email' => 'librarian@library.com',
            'password' => bcrypt('password'),
            'role_id' => $librarianRole->id,
            'employee_id' => 'LIB001',
        ]);

        // Create headmaster user
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'headmaster@library.com',
            'password' => bcrypt('password'),
            'role_id' => $headmasterRole->id,
            'employee_id' => 'HMS001',
        ]);

        // Create app settings
        AppSetting::create([
            'key' => 'school_name',
            'value' => 'SMK Negeri 1 Informatika',
            'type' => 'text',
            'description' => 'School name for reports and member cards',
        ]);

        AppSetting::create([
            'key' => 'school_logo',
            'value' => null,
            'type' => 'file',
            'description' => 'School logo for reports and member cards',
        ]);

        AppSetting::create([
            'key' => 'default_loan_days',
            'value' => '7',
            'type' => 'number',
            'description' => 'Default number of days for book loans',
        ]);

        AppSetting::create([
            'key' => 'fine_per_day',
            'value' => '1000',
            'type' => 'number',
            'description' => 'Fine amount per day for overdue books',
        ]);

        // Create book shelves
        $shelves = [
            ['code' => 'A1', 'name' => 'Fiction - A1'],
            ['code' => 'A2', 'name' => 'Fiction - A2'],
            ['code' => 'B1', 'name' => 'Non-Fiction - B1'],
            ['code' => 'B2', 'name' => 'Non-Fiction - B2'],
            ['code' => 'C1', 'name' => 'Reference - C1'],
            ['code' => 'D1', 'name' => 'Textbooks - D1'],
        ];

        foreach ($shelves as $shelf) {
            BookShelf::create($shelf);
        }

        // Create categories
        $categories = [
            ['name' => 'Fiction'],
            ['name' => 'Non-Fiction'],
            ['name' => 'Science'],
            ['name' => 'History'],
            ['name' => 'Literature'],
            ['name' => 'Technology'],
            ['name' => 'Mathematics'],
            ['name' => 'Language'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create authors
        $authors = [
            ['name' => 'Andrea Hirata', 'nationality' => 'Indonesia'],
            ['name' => 'Tere Liye', 'nationality' => 'Indonesia'],
            ['name' => 'Pramoedya Ananta Toer', 'nationality' => 'Indonesia'],
            ['name' => 'Habiburrahman El Shirazy', 'nationality' => 'Indonesia'],
            ['name' => 'Dewi Lestari', 'nationality' => 'Indonesia'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }

        // Create publishers
        $publishers = [
            ['name' => 'Gramedia Pustaka Utama'],
            ['name' => 'Mizan'],
            ['name' => 'Erlangga'],
            ['name' => 'Bentang Pustaka'],
            ['name' => 'Republika'],
        ];

        foreach ($publishers as $publisher) {
            Publisher::create($publisher);
        }

        // Create school classes
        $classes = [
            ['name' => 'X', 'level' => 'Senior High School'],
            ['name' => 'XI', 'level' => 'Senior High School'],
            ['name' => 'XII', 'level' => 'Senior High School'],
        ];

        foreach ($classes as $class) {
            SchoolClass::create($class);
        }

        // Create majors
        $majors = [
            ['name' => 'Teknik Komputer dan Jaringan', 'code' => 'TKJ'],
            ['name' => 'Rekayasa Perangkat Lunak', 'code' => 'RPL'],
            ['name' => 'Multimedia', 'code' => 'MM'],
            ['name' => 'Teknik Elektronika Industri', 'code' => 'TEI'],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }

        // Create sample books
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'isbn' => '9786020311234',
                'publication_year' => 2005,
                'quantity' => 5,
                'available_quantity' => 5,
                'book_shelf_id' => 1,
                'category_id' => 1,
                'author_id' => 1,
                'publisher_id' => 1,
            ],
            [
                'title' => 'Bumi',
                'isbn' => '9786020314567',
                'publication_year' => 2014,
                'quantity' => 3,
                'available_quantity' => 3,
                'book_shelf_id' => 1,
                'category_id' => 1,
                'author_id' => 2,
                'publisher_id' => 2,
            ],
            [
                'title' => 'Bumi Manusia',
                'isbn' => '9786020318901',
                'publication_year' => 1980,
                'quantity' => 4,
                'available_quantity' => 4,
                'book_shelf_id' => 2,
                'category_id' => 5,
                'author_id' => 3,
                'publisher_id' => 1,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Create sample members
        Member::create([
            'nisn_nip' => '1234567890',
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad@student.com',
            'address' => 'Jl. Contoh No. 123',
            'phone' => '081234567890',
            'member_type' => 'student',
            'status' => 'active',
            'school_class_id' => 2,
            'major_id' => 1,
        ]);

        Member::create([
            'nisn_nip' => '0987654321',
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@student.com',
            'address' => 'Jl. Contoh No. 456',
            'phone' => '081234567891',
            'member_type' => 'student',
            'status' => 'active',
            'school_class_id' => 3,
            'major_id' => 2,
        ]);
    }
}