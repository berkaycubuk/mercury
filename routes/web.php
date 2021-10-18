<?php

use Illuminate\Support\Facades\Route;

/**
 * Frontpage routes
 */

// Homepage
Route::get("/", "Store@index")
    ->name("store.index");

// Product
Route::get("urun/{slug}", "Store@product")
    ->name("store.product");
Route::get("urunler/{slug}", "Store@products")
    ->name("store.products");

// Online Order
Route::get("online-siparis", "OnlineOrder@index")
    ->name("store.order-online");

// Sözleşmeler
/*
Route::get("sozlesmeler", "Agreements\Agreements@index")
    ->name("store.agreements.index");
Route::get("sozlesmeler/kvkk", "Agreements\Agreements@kvkk")
    ->name("store.agreements.kvkk");
Route::get("sozlesmeler/satis-sozlesmesi", "Agreements\Agreements@satis")
    ->name("store.agreements.satis");
Route::get("sozlesmeler/cerez-politikasi", "Agreements\Agreements@cerez")
    ->name("store.agreements.cerez");
 */

// Menu
Route::get("menu", "Products\Menu@index")
    ->name("store.menu");
Route::get("menu/{slug}", "Products\Menu@branchMenu")
    ->name("store.menu.branch-menu");

// Blog
Route::get("blog", "Blog\Blog@index")
    ->name("store.blog.index");
Route::get("blog/{slug}", "Blog\Blog@post")
    ->name("store.blog.post");

// About Us
/*
Route::get("hakkimizda", "Store@aboutUs")
    ->name("shore.about-us");
*/

// Contact
Route::get("iletisim", "Contact@index")
    ->name("store.contact.index");
Route::post("iletisim", "Contact@submit")
    ->name("store.contact.submit");

// Cart
Route::get("sepet", "Store@cart")
    ->name("store.cart");
Route::post("sepet/add", "Carts\Carts@add")
    ->name("store.cart.add");
Route::post("sepet/remove", "Carts\Carts@remove")
    ->name("store.cart.remove");
Route::post("sepet/delete", "Carts\Carts@delete")
    ->name("store.cart.delete");
Route::post("sepet/empty_cart", "Carts\Carts@emptyCart")
    ->name("store.cart.emptyCart");
Route::post("sepet/kupon-kodu/apply", "Carts\Carts@applyCoupon")
    ->name("store.cart.coupon-code.apply");
Route::post("sepet/kupon-kodu/delete", "Carts\Carts@deleteCoupon")
    ->name("store.cart.coupon-code.delete");

// Checkout & Payment
Route::get("checkout", "Carts\Checkout@index")
    ->name("store.checkout.index");
Route::post("checkout/save-information", "Carts\Checkout@saveInformation")
    ->name("store.checkout.save-information");
Route::get("checkout/odeme", "Carts\Checkout@paymentPage")
    ->name("store.checkout.payment-page");
Route::get("checkout/basarili", "Carts\Checkout@successPage")
    ->name("store.checkout.success");
Route::get("checkout/hatali", "Carts\Checkout@errorPage")
    ->name("store.checkout.error");

Route::post("checkout/process-payment", "Payments\Payments@process")
    ->name("store.checkout.process-payment");

Route::post("checkout/store", "Orders\Orders@store")
    ->name("store.checkout.store");
Route::get("checkout/payment/stripe/{id}", "Store@stripePayment")
    ->name("store.checkout.payment.stripe");
Route::post(
    "checkout/payment/stripe/submit",
    "Orders\Orders@stripePayment"
)->name("store.payment.stripe.submit");
Route::get("checkout/success", "Store@orderSuccess")
    ->name("store.checkout.success");

// Locations
Route::get("locations/cities", "Locations@cities")
    ->name("store.locations.cities");
Route::get("locations/districts", "Locations@districts")
    ->name("store.locations.districts");
Route::get("locations/neighborhoods", "Locations@neighborhoods")
    ->name("store.locations.neighborhoods");
Route::get("shipment/choices", "Locations@shipmentChoices")
    ->name("store.shipment.choices");

// Orders
// Geçici olarak sipariş sorgulama devre dışı bırakıldı
/* Route::get("siparis-takibi", "Orders\TrackOrders@search")
    ->name("store.track-orders.search");
Route::get("siparis-takibi/{code}", "Orders\TrackOrders@result")
    ->name("store.track-orders.result");
Route::post("siparis-takibi/query", "Orders\TrackOrders@query")
    ->name("store.track-orders.query"); */

// Account
Route::get("hesap", "Store@account")
    ->middleware("auth")
    ->name("store.account");
Route::get("hesap/adresler", "Auth\Addresses@index")
    ->middleware("auth")
    ->name("store.addresses.index");
Route::post("hesap/adresler/delete", "Auth\Addresses@delete")
    ->middleware("auth")
    ->name("store.addresses.delete");
Route::post("hesap/adreslser/update", "Auth\Addresses@update")
    ->middleware("auth")
    ->name("store.addresses.update");
Route::post("hesap/adresler/create", "Auth\Addresses@create")
    ->middleware("auth")
    ->name("store.addresses.create");
Route::get("hesap/siparisler", "Store@orders")
    ->middleware("auth")
    ->name("store.orders");
Route::get("hesap/siparisler/{code}", "Store@orderDetails")
    ->middleware("auth")
    ->name("store.orders.details");
Route::get("hesap/ayarlar", "Auth\Settings@index")
    ->middleware("auth")
    ->name("store.settings.index");
Route::post("hesap/ayarlar/update", "Auth\Settings@update")
    ->middleware("auth")
    ->name("store.settings.update");
Route::post("hesap/ayarlar/update-password", "Auth\Settings@updatePassword")
    ->middleware("auth")
    ->name("store.settings.update-password");

// Auth
Route::get("giris", "Store@loginView")
    ->middleware('guest')
    ->name("store.login");
Route::get("kayit", "Store@registerView")
    ->middleware('guest')
    ->name("store.register");
Route::get("aktivasyon/{code}/{id}", "Auth\Register@activate")
    ->name("store.auth.activate");
Route::get("sifre-yenile", "Store@renewPasswordView")
    ->middleware('guest')
    ->name("password.request");
Route::get('sifre-yenile/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post("renew-password", "Store@renewPassword")
    ->middleware('guest')
    ->name("password.email");
Route::post("reset-password", "Store@resetPassword")
    ->middleware('guest')
    ->name('password.update');

Route::post("login", "Auth\Login@submit")
    ->middleware('guest')
    ->name("store.auth.login");
Route::post("register", "Auth\Register@submit")
    ->middleware('guest')
    ->name("store.auth.register");
Route::get("cikis", "Store@logout")
    ->middleware("auth")
    ->name("store.logout");

// 404
Route::get("404", function() {
    return view('404');
})->name("store.404");

/**
 * Panel routes
 */
Route::group(["prefix" => "panel"], function () {
    // Dashboard
    Route::get("/", "Home\Home@index")
        ->middleware("user.panel")
        ->name("panel.homepage.index");

    Route::get("analytics", function () {
        return view("panel.analytics");
    })->name("panel.homepage.analytics");

    // Auth
    Route::get("login", "Auth\Login@index")->name("panel.login");
    Route::post("login/submit", "Auth\Login@submit")->name(
        "panel.login.submit"
    );
    Route::get("logout", "Auth\Logout@logout")->name("panel.logout");
    Route::get("bildirimler", "Auth\Notifications@index")->name("panel.notifications");
    Route::get("bildirim/sil/{id}", "Auth\Notifications@delete")->name("panel.notifications.delete");
    Route::get("bildirim/{id}", "Auth\Notifications@details")->name("panel.notifications.details");

    // Product Attributes
    Route::get("urunler/ozelliker", "Products\ProductAttributes@index")
        ->middleware("user.admin")
        ->name("panel.products.attributes.index");
    Route::get("urunler/ozelliker/{id}", "Products\ProductAttributes@edit")
        ->middleware("user.admin")
        ->name("panel.products.attributes.edit");
    Route::post("urunler/ozelliker/update", "Products\ProductAttributes@update")
        ->middleware("user.admin")
        ->name("panel.products.attributes.update");
    Route::get("urunler/ozelliker/{id}/ifadeler", "Products\ProductAttributes@editTerms")
        ->middleware("user.admin")
        ->name("panel.products.attributes.edit-terms");
    Route::post("urunler/ozelliker/create", "Products\ProductAttributes@create")
        ->middleware("user.admin")
        ->name("panel.products.attributes.create");
    Route::post("urunler/ozelliker/create-term", "Products\ProductAttributes@createTerm")
        ->middleware("user.admin")
        ->name("panel.products.attributes.create-term");
    Route::get("urunler/ozelliker/delete/{id}", "Products\ProductAttributes@delete")
        ->middleware("user.admin")
        ->name("panel.products.attributes.delete");
    Route::get("urunler/ozelliker/delete-term/{id}/{id2}", "Products\ProductAttributes@deleteTerm")
        ->middleware("user.admin")
        ->name("panel.products.attributes.delete-term");

    // Products
    Route::get("urunler", "Products\Products@index")
        ->middleware("user.admin")
        ->name("panel.products.products.index");
    Route::get("urunler/yeni", "Products\Products@create")
        ->middleware("user.admin")
        ->name("panel.products.products.create");
    Route::get("urunler/export", "Products\Products@export")
        ->middleware("user.admin")
        ->name("panel.products.products.export");
    Route::post("urunler/import", "Products\Products@import")
        ->middleware("user.admin")
        ->name("panel.products.products.import");
    Route::post("urunler/store", "Products\Products@store")
        ->middleware("user.admin")
        ->name("panel.products.products.store");
    Route::get("urunler/kategoriler", "Products\ProductCategories@index")
        ->middleware("user.admin")
        ->name("panel.products.categories.index");
    Route::get("urunler/kategoriler/yeni", "Products\ProductCategories@create")
        ->middleware("user.admin")
        ->name("panel.products.categories.create");
    Route::get("urunler/kategoriler/export", "Products\ProductCategories@export")
        ->middleware("user.admin")
        ->name("panel.products.categories.export");
    Route::post("urunler/kategoriler/store", "Products\ProductCategories@store")
        ->middleware("user.admin")
        ->name("panel.products.categories.store");
    Route::post("urunler/kategoriler/import", "Products\ProductCategories@import")
        ->middleware("user.admin")
        ->name("panel.products.categories.import");
    Route::post(
        "urunler/kategoriler/update",
        "Products\ProductCategories@update"
    )
        ->middleware("user.admin")
        ->name("panel.products.categories.update");
    Route::get("urunler/kategoriler/{id}", "Products\ProductCategories@edit")
        ->middleware("user.admin")
        ->name("panel.products.categories.edit");
    Route::post("urunler/kategoriler/delete","Products\ProductCategories@delete")
        ->middleware("user.admin")
        ->name("panel.products.categories.delete");

    // Product Subcategories
    Route::get("urunler/altkategoriler", "Products\Subcategories@index")
        ->middleware("user.admin")
        ->name("panel.products.subcategories.index");
    Route::get("urunler/altkategoriler/yeni", "Products\Subcategories@create")
        ->middleware("user.admin")
        ->name("panel.products.subcategories.create");
    Route::get("urunler/altkategoriler/export", "Products\Subcategories@export")
        ->middleware("user.admin")
        ->name("panel.products.subcategories.export");
    Route::post("urunler/altkategoriler/store", "Products\Subcategories@store")
        ->middleware("user.admin")
        ->name("panel.products.subcategories.store");
    Route::post("urunler/altkategoriler/import", "Products\Subcategories@import")
        ->middleware("user.admin")
        ->name("panel.products.subcategories.import");
    Route::post(
        "urunler/altkategoriler/update",
        "Products\Subcategories@update"
    )
        ->middleware("user.admin")
        ->name("panel.products.subcategories.update");
    Route::get("urunler/altkategoriler/{id}", "Products\Subcategories@edit")
        ->middleware("user.admin")
        ->name("panel.products.subcategories.edit");
    Route::post("urunler/altkategoriler/delete","Products\Subcategories@delete")
        ->middleware("user.admin")
        ->name("panel.products.subcategories.delete");

    //

    Route::post("urunler/update", "Products\Products@update")
        ->middleware("user.admin")
        ->name("panel.products.products.update");
    Route::post("urunler/delete", "Products\Products@delete")
        ->middleware("user.admin")
        ->name("panel.products.products.delete");
    Route::get("urunler/{id}", "Products\Products@edit")
        ->middleware("user.admin")
        ->name("panel.products.products.edit");


    // Orders
    Route::get("siparisler", "Orders\Orders@index")
        ->middleware("user.admin")
        ->name("panel.orders.index");
    Route::get("siparisler/delete/{id}", "Orders\Orders@delete")
        ->middleware("user.admin")
        ->name("panel.orders.delete");
    Route::get("siparisler/{id}", "Orders\Orders@edit")
        ->middleware("user.admin")
        ->name("panel.orders.edit");
    Route::post("siparisler/update", "Orders\Orders@update")
        ->middleware("user.admin")
        ->name("panel.orders.update");

    // Pages
    Route::get("pages", "Pages\Pages@index")
        ->middleware("user.admin")
        ->name("panel.pages.index");
    Route::get("pages/create", "Pages\Pages@create")
        ->middleware("user.admin")
        ->name("panel.pages.create");
    Route::post("pages/store", "Pages\Pages@store")
        ->middleware("user.admin")
        ->name("panel.pages.store");
    Route::post("pages/update", "Pages\Pages@update")
        ->middleware("user.admin")
        ->name("panel.pages.update");
    Route::post("pages/delete", "Pages\Pages@delete")
        ->middleware("user.admin")
        ->name("panel.pages.delete");
    Route::get("pages/{id}", "Pages\Pages@edit")
        ->middleware("user.admin")
        ->name("panel.pages.edit");

    // Blog
    Route::get("blog", "Blog\Posts@index")
        ->middleware("user.panel")
        ->name("panel.blog.posts.index");
    Route::get("blog/yeni", "Blog\Posts@create")
        ->middleware("user.panel")
        ->name("panel.blog.posts.create");
    Route::post("blog/store", "Blog\Posts@store")
        ->middleware("user.panel")
        ->name("panel.blog.posts.store");
    Route::post("blog/update", "Blog\Posts@update")
        ->middleware("user.panel")
        ->name("panel.blog.posts.update");
    Route::post("blog/delete", "Blog\Posts@delete")
        ->middleware("user.panel")
        ->name("panel.blog.posts.delete");
    Route::get("blog/kategoriler", "Blog\PostCategories@index")
        ->middleware("user.panel")
        ->name("panel.blog.categories.index");
    Route::get("blog/kategoriler/yeni", "Blog\PostCategories@create")
        ->middleware("user.panel")
        ->name("panel.blog.categories.create");
    Route::post("blog/kategoriler/store", "Blog\PostCategories@store")
        ->middleware("user.panel")
        ->name("panel.blog.categories.store");
    Route::post("blog/kategoriler/update", "Blog\PostCategories@update")
        ->middleware("user.panel")
        ->name("panel.blog.categories.update");
    Route::get("blog/kategoriler/{id}", "Blog\PostCategories@edit")
        ->middleware("user.panel")
        ->name("panel.blog.categories.edit");
    Route::get("blog/kategoriler/delete/{id}", "Blog\PostCategories@delete")
        ->middleware("user.panel")
        ->name("panel.blog.categories.delete");
    Route::get("blog/etiketler", "Blog\PostTags@index")
        ->middleware("user.panel")
        ->name("panel.blog.tags.index");
    Route::get("blog/etiketler/yeni", "Blog\PostTags@create")
        ->middleware("user.panel")
        ->name("panel.blog.tags.create");
    Route::post("blog/etiketler/store", "Blog\PostTags@store")
        ->middleware("user.panel")
        ->name("panel.blog.tags.store");
    Route::post("blog/etiketler/update", "Blog\PostTags@update")
        ->middleware("user.panel")
        ->name("panel.blog.tags.update");
    Route::get("blog/etiketler/{id}", "Blog\PostTags@edit")
        ->middleware("user.panel")
        ->name("panel.blog.tags.edit");
    Route::get("blog/etiketler/delete/{id}", "Blog\PostTags@delete")
        ->middleware("user.panel")
        ->name("panel.blog.tags.delete");
    Route::get("blog/{id}", "Blog\Posts@edit")
        ->middleware("user.panel")
        ->name("panel.blog.posts.edit");

    // Users
    Route::get("kullanicilar", "Auth\Users@index")
        ->middleware("user.admin")
        ->name("panel.users.index");
    Route::get("kullanicilar/yeni", "Auth\Users@create")
        ->middleware("user.admin")
        ->name("panel.users.create");
    Route::post("kullanicilar/store", "Auth\Users@store")
        ->middleware("user.admin")
        ->name("panel.users.store");
    Route::post("kullanicilar/update", "Auth\Users@update")
        ->middleware("user.admin")
        ->name("panel.users.update");
    Route::post("kullanicilar/delete", "Auth\Users@delete")
        ->middleware("user.admin")
        ->name("panel.users.delete");
    Route::get("kullanicilar/export", "Auth\Users@export")
        ->middleware("user.admin")
        ->name("panel.users.export");
    Route::post("kullanicilar/import", "Auth\Users@import")
        ->middleware("user.admin")
        ->name("panel.users.import");
    Route::get("kullanicilar/{id}", "Auth\Users@edit")
        ->middleware("user.admin")
        ->name("panel.users.edit");

    // Media
    Route::get("medya", "Media\Media@index")
        ->middleware("user.admin")
        ->name("panel.media.index");
    Route::get("medya/yeni", "Media\Media@create")
        ->middleware("user.admin")
        ->name("panel.media.create");
    Route::post("medya/upload", "Media\Media@upload")
        ->middleware("user.admin")
        ->name("panel.media.upload");
    Route::post("medya/store", "Media\Media@store")
        ->middleware("user.admin")
        ->name("panel.media.store");
    Route::post("medya/update", "Media\Media@update")
        ->middleware("user.admin")
        ->name("panel.media.update");
    Route::get("medya/delete/{id}", "Media\Media@delete")
        ->middleware("user.admin")
        ->name("panel.media.delete");
    Route::get("medya/{id}", "Media\Media@edit")
        ->middleware("user.admin")
        ->name("panel.media.edit");

    // Coupons
    Route::get("pazarlama/kuponlar", "Marketing\Coupons@index")
        ->middleware("user.admin")
        ->name("panel.marketing.coupons.index");
    Route::get("pazarlama/kuponlar/ekle", "Marketing\Coupons@create")
        ->middleware("user.admin")
        ->name("panel.marketing.coupons.create");
    Route::get("pazarlama/kuponlar/{id}", "Marketing\Coupons@edit")
        ->middleware("user.admin")
        ->name("panel.marketing.coupons.edit");
    Route::post("pazarlama/kuponlar/sil", "Marketing\Coupons@delete")
        ->middleware("user.admin")
        ->name("panel.marketing.coupons.delete");
    Route::post("pazarlama/kuponlar/store", "Marketing\Coupons@store")
        ->middleware("user.admin")
        ->name("panel.marketing.coupons.store");
    Route::post("pazarlama/kuponlar/update", "Marketing\Coupons@update")
        ->middleware("user.admin")
        ->name("panel.marketing.coupons.update");

    Route::get("yardim/destek-talepleri", function () {
        return view("panel.support.tickets");
    })->name("panel.support.tickets");

    // Settings
    Route::get("ayarlar/genel", "Settings\General@index")
        ->middleware("user.admin")
        ->name("panel.settings.general");
    Route::post("ayarlar/genel/update", "Settings\General@update")
        ->middleware("user.admin")
        ->name("panel.settings.general.update");

    // Contact
    Route::get("ayarlar/iletisim", "Settings\Contact@index")
        ->middleware("user.admin")
        ->name("panel.settings.contact");
    Route::post("ayarlar/iletisim/update", "Settings\Contact@update")
        ->middleware("user.admin")
        ->name("panel.settings.contact.update");

    // Mail
    Route::get("ayarlar/mail", "Settings\Mail@index")
        ->middleware("user.admin")
        ->name("panel.settings.mail");

    // SEO
    Route::get("ayarlar/seo", "Settings\SEO@index")
        ->middleware("user.admin")
        ->name("panel.settings.seo");
    Route::get("ayarlar/entegrasyonlar", "Settings\Integrations@index")
        ->middleware("user.admin")
        ->name("panel.settings.integrations");

    // Social Media
    Route::get("ayarlar/sosyal-medya", "Settings\Social@index")
        ->middleware("user.admin")
        ->name("panel.settings.social");
    Route::post("ayarlar/sosyal-medya/update", "Settings\Social@update")
        ->middleware("user.admin")
        ->name("panel.settings.social.update");

    // Frontpage
    Route::get("ayarlar/anasayfa", "Settings\Frontpage@index")
        ->middleware("user.admin")
        ->name("panel.settings.frontpage");
    Route::post("ayarlar/anasayfa/update", "Settings\Frontpage@update")
        ->middleware("user.admin")
        ->name("panel.settings.frontpage.update");

    // Menu
    Route::get("ayarlar/menu", "Settings\Menu@index")
        ->middleware("user.admin")
        ->name("panel.settings.menu");
    Route::post("ayarlar/menu/update", "Settings\Menu@update")
        ->middleware("user.admin")
        ->name("panel.settings.menu.update");

    // Shipment
    Route::get("ayarlar/teslimat", "Settings\Shipment@index")
        ->middleware("user.admin")
        ->name("panel.settings.shipment");
    Route::get("ayarlar/teslimat/yeni", "Settings\Shipment@create")
        ->middleware("user.admin")
        ->name("panel.settings.shipment.create");
    Route::get("ayarlar/teslimat/{id}", "Settings\Shipment@edit")
        ->middleware("user.admin")
        ->name("panel.settings.shipment.edit");
    Route::post("ayarlar/teslimat/store", "Settings\Shipment@store")
        ->middleware("user.admin")
        ->name("panel.settings.shipment.store");
    Route::post("ayarlar/teslimat/update", "Settings\Shipment@update")
        ->middleware("user.admin")
        ->name("panel.settings.shipment.update");
    Route::post("ayarlar/teslimat/delete", "Settings\Shipment@delete")
        ->middleware("user.admin")
        ->name("panel.settings.shipment.delete");

    // Branches
    Route::get("ayarlar/iletisim/subeler/yeni", "Settings\Contact\Branches@createPage")
        ->middleware("user.admin")
        ->name("panel.settings.contact.branches.create-page");
    Route::get("ayarlar/iletisim/subeler/duzenle/{id}", "Settings\Contact\Branches@editPage")
        ->middleware("user.admin")
        ->name("panel.settings.contact.branches.edit-page");
    Route::get("ayarlar/iletisim/subeler/sil/{id}", "Settings\Contact\Branches@delete")
        ->middleware("user.admin")
        ->name("panel.settings.contact.branches.delete");
    Route::post("ayarlar/iletisim/subeler/yeni", "Settings\Contact\Branches@create")
        ->middleware("user.admin")
        ->name("panel.settings.contact.branches.create");
    Route::post("ayarlar/iletisim/subeler/guncelle", "Settings\Contact\Branches@update")
        ->middleware("user.admin")
        ->name("panel.settings.contact.branches.update");

    Route::get("guncelle", function(\Codedge\Updater\UpdaterManager $updater) {
        if ($updater->source()->isNewVersionAvailable()) {
            echo $updater->source()->getVersionInstalled();
            $versionAvailable = $updater->source()->getVersionAvailable();
            $release = $updater->source()->fetch($versionAvailable);
            $updater->source()->update($release);

            return back()->with('message', 'Başarıyla güncellendi!');
        } else {
            return back()->with('message', 'Zaten son sürümü kullanıyorsunuz');
        }
    })->middleware("user.admin")->name('panel.update');
    Route::get("guncellemeler", function(\Codedge\Updater\UpdaterManager $updater) {
        return view('panel.updates', [
            'updateAvailable' => $updater->source()->isNewVersionAvailable(),
            'currentVersion' => $updater->source()->getVersionInstalled(),
            'availableVersion' => $updater->source()->getVersionAvailable(),
        ]);
    })->middleware("user.admin")->name('panel.updates');

    // 404
    Route::fallback(function () {
        return view("panel.404");
    })->middleware("user.admin")->name("panel.404");
});

// Page routes created by panel users
Route::get("/{slug}", "Store@page")->name("store.page");
