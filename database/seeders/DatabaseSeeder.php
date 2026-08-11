<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ------------------------------------------------------------
        // Users
        // ------------------------------------------------------------
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $members = collect([
            ['name' => 'Layla Haddad', 'email' => 'layla@gmail.com'],
            ['name' => 'Omar Nasser', 'email' => 'omar@gmail.com'],
            ['name' => 'Sara Youssef', 'email' => 'sara@gmail.com'],
        ])->map(function ($data) {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        });

        // ------------------------------------------------------------
        // Authors
        // ------------------------------------------------------------
        $authors = collect([
            'George Orwell',
            'J.K. Rowling',
            'Jane Austen',
            'Yuval Noah Harari',
            'Naguib Mahfouz',
            'Agatha Christie',
        ])->map(fn ($name) => Author::create(['name' => $name]));

        // ------------------------------------------------------------
        // Categories
        // ------------------------------------------------------------
        $categories = collect([
            'Fiction',
            'Non-Fiction',
            'Philosophy',
            'Programming',
            'History',
            'Science',
            'Psychology',
            'Biography',
        ])->map(fn ($name) => Category::create(['name' => $name]));

        // ------------------------------------------------------------
        // Books
        // ------------------------------------------------------------
        $bookData = [
            ['title' => '1984', 'author' => 'George Orwell', 'category' => 'Fiction', 'copies' => 4],
            ['title' => 'Animal Farm', 'author' => 'George Orwell', 'category' => 'Fiction', 'copies' => 3],
            ['title' => "Harry Potter and the Sorcerer's Stone", 'author' => 'J.K. Rowling', 'category' => 'Fiction', 'copies' => 5],
            ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'category' => 'Fiction', 'copies' => 2],
            ['title' => 'Sapiens: A Brief History of Humankind', 'author' => 'Yuval Noah Harari', 'category' => 'History', 'copies' => 3],
            ['title' => 'Homo Deus', 'author' => 'Yuval Noah Harari', 'category' => 'Science', 'copies' => 2],
            ['title' => 'Palace Walk', 'author' => 'Naguib Mahfouz', 'category' => 'Fiction', 'copies' => 2],
            ['title' => 'Murder on the Orient Express', 'author' => 'Agatha Christie', 'category' => 'Fiction', 'copies' => 3],
            ['title' => 'And Then There Were None', 'author' => 'Agatha Christie', 'category' => 'Fiction', 'copies' => 4],
            ['title' => 'The Republic', 'author' => 'George Orwell', 'category' => 'Philosophy', 'copies' => 1],
            ['title' => 'Clean Code', 'author' => 'J.K. Rowling', 'category' => 'Programming', 'copies' => 3],
            ['title' => 'Thinking, Fast and Slow', 'author' => 'Jane Austen', 'category' => 'Psychology', 'copies' => 2],
        ];

        $books = collect($bookData)->map(function ($data) use ($authors, $categories) {
            return Book::create([
                'title' => $data['title'],
                'author_id' => $authors->firstWhere('name', $data['author'])->id,
                'category_id' => $categories->firstWhere('name', $data['category'])->id,
                'total_copies' => $data['copies'],
                'available_copies' => $data['copies'],
            ]);
        });

        // ------------------------------------------------------------
        // Borrowings (mix of returned, active, and overdue)
        // ------------------------------------------------------------
        $this->borrow($books[0], $members[0], daysAgo: 20, dueInDays: -6, returned: false); // overdue
        $this->borrow($books[2], $members[1], daysAgo: 3, dueInDays: 11, returned: false);  // active
        $this->borrow($books[4], $members[2], daysAgo: 10, dueInDays: 4, returned: false);  // active
        $this->borrow($books[7], $members[0], daysAgo: 25, dueInDays: -11, returned: true); // returned late
        $this->borrow($books[8], $members[1], daysAgo: 15, dueInDays: -1, returned: true);  // returned on time
        $this->borrow($books[1], $members[2], daysAgo: 30, dueInDays: -16, returned: true);
    }

    private function borrow(Book $book, User $user, int $daysAgo, int $dueInDays, bool $returned): void
    {
        $borrowedAt = now()->subDays($daysAgo);
        $dueDate = now()->addDays($dueInDays);

        Borrowing::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'borrowed_at' => $borrowedAt,
            'due_date' => $dueDate,
            'returned_at' => $returned ? $dueDate->copy()->addDays(2) : null,
        ]);

        if (! $returned) {
            $book->decrement('available_copies');
        }
    }
}