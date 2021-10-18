<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CoreV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Failed jobs
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // Temporary Files
        Schema::create('temporary_files', function (Blueprint $table) {
            $table->id();
            $table->string('folder');
            $table->string('filename');
            $table->timestamps();
        });

        // Posts
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('slug')->unique();
            $table->integer('thumbnail')->nullable();
            $table->integer('category')->nullable();
            $table->string('tags')->nullable();
            $table->string('author');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        // Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('slug')->unique();
            $table->double('price', 8, 2);
            $table->json('images')->nullable();
            $table->foreignId('product_category_id')->nullable()->index();
            $table->foreignId('subcategory_id')->nullable()->index();
            $table->json('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('product_subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('product_category_id')->nullable()->index();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('terms')->nullable();
            $table->timestamps();
        });

        // Transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->text('meta');
            $table->timestamps();
            $table->softDeletes();
        });

        // Cart
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->text('items')->nullable();
            $table->json('meta')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();
        });

        // Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user')->nullable();
            $table->integer('state')->default(0);
            $table->json('meta');
            $table->timestamps();
            $table->softDeletes();
        });

        // Pages
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Media
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->timestamps();
            $table->softDeletes();
        });

        // Password resets
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('role')->default('customer');
            $table->rememberToken();
            $table->string('activation_code');
            $table->json('meta')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Addresses
        Schema::create('addresses', function(Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('details');
            $table->string('type');
            $table->boolean('primary')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // Coupons
        Schema::create('coupons', function(Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->string('discount_type')->default('fixed-cart');
            $table->double('discount', 8, 2)->default(0);
            $table->boolean('free_shipping')->default(false);
            $table->timestamp('expires_at');
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Sessions
        Schema::create('sessions', function ($table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity')->index();
        });

        // Locations
        Schema::create('locations_cities', function ($table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('locations_districts', function ($table) {
            $table->id();
            $table->foreignId('city_id')->nullable()->index();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('locations_neighborhoods', function ($table) {
            $table->id();
            $table->foreignId('district_id')->nullable()->index();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('failed_jobs');
        Schema::drop('temporary_files');
        Schema::drop('posts');
        Schema::drop('post_categories');
        Schema::drop('post_tags');
        Schema::drop('products');
        Schema::drop('product_categories');
        Schema::drop('product_subcategories');
        Schema::drop('product_attributes');
        Schema::drop('password_resets');
        Schema::drop('users');
        Schema::drop('media');
        Schema::drop('transactions');
        Schema::drop('carts');
        Schema::drop('settings');
    }
}
