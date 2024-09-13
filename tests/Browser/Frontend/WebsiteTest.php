<?php

namespace Tests\Browser\Frontend;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WebsiteTest extends DuskTestCase
{
    use WithFaker;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testHomepageWithoutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('/')
                ->assertSee('Sign In');
        });
    }


    public function testHomepageWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/')
                ->assertSee('Category');
        });
    }

    public function testGetCoursesByCategoryWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('get-courses-by-category/1')
                ->pause(5000)
                ->assertSee('Admin');
        });
    }


    public function testGetCoursesByCategoryWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('get-courses-by-category/1')
                ->assertSee('Admin');
        });
    }


//    public function testFooterPageWithoutAuth()
//    {
//        $this->browse(function (Browser $browser) {
//            $browser->visit('/logout')->visit('footer/page/unlock-your-potential')
//                ->assertSee('Unlock Your Potential');
//        });
//    }
//
//    public function testFooterPageWithAuth()
//    {
//        $this->browse(function (Browser $browser) {
//            $browser->loginAs(1)->visit('footer/page/unlock-your-potential')
//                ->assertSee('Unlock Your Potential');
//        });
//    }

    public function testAboutUsWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('about-us')
                ->assertSee('About Company');
        });
    }

    public function testAboutUsWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('about-us')
                ->assertSee('About Company');
        });
    }


    public function testContactWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('contact-us')
                ->assertSee('Contact Us');
        });
    }

    public function testContactWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->loginAs(1)->visit('contact-us')
                ->assertSee('Contact Us');
        });
    }


    public function testContactSubmitWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('contact-us')
                ->type('name', $this->faker->name)
                ->type('email', $this->faker->email)
                ->type('subject', $this->faker->text)
                ->type('message', $this->faker->text)
                ->click('#myForm > div > div.col-lg-12.text-left > button')
                ->pause(5000)
                ->assertSee('Successfully Sent Message');
        });
    }

    public function testContactSubmitWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('contact-us')
                ->type('name', $this->faker->name)
                ->type('email', $this->faker->email)
                ->type('subject', $this->faker->text)
                ->type('message', $this->faker->text)
                ->click('#myForm > div > div.col-lg-12.text-left > button')
                ->pause(5000)
                ->assertSee('Successfully Sent Message');
        });
    }


    public function testPrivacyPageWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('privacy')
                ->assertSee('Privacy Policies');
        });
    }

    public function testPrivacyPageWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('privacy')
                ->assertSee('Privacy Policies');
        });
    }

    public function testInstructorWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('instructors')
                ->assertSee('Instructor');
        });
    }

    public function testInstructorWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('instructors')
                ->assertSee('Instructor');
        });
    }


    public function testBecomeInstructorWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('become-instructor')
                ->assertSee('Become Instructor');
        });
    }

    public function testBecomeInstructorWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('become-instructor')
                ->assertSee('Become Instructor');
        });
    }


    public function testInstructorDetailsWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('instructorDetails/2/teacher')
                ->assertSee('Instructor');
        });
    }

    public function testInstructorDetailsWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('become-instructor')
                ->assertSee('Instructor');
        });
    }


    public function testCoursesWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('courses')
                ->assertSee('Courses');
        });
    }

    public function testCoursesWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('courses')
                ->assertSee('Courses');
        });
    }

    public function testQuizzesWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('quizzes')
                ->assertSee('Quizzes');
        });
    }

    public function testQuizzesWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('quizzes')
                ->assertSee('Quizzes');
        });
    }


    public function testClassesWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('classes')
                ->assertSee('Classes');
        });
    }

    public function testClassesWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('classes')
                ->assertSee('Classes');
        });
    }

    public function testSearchWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('search?query=laravel')
                ->assertSee('Search result for');
        });
    }

    public function testSearchWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('search?query=laravel')
                ->assertSee('Search result for');
        });
    }


    public function testCourseDetailsWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('courses-details/managerial-accounting')
                ->assertSee('Course Details');
        });
    }

    public function testCourseDetailsWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('courses-details/managerial-accounting')
                ->assertSee('Course Details');
        });
    }

    public function testQuizDetailsWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('quiz-details/quiz-for-php')
                ->assertSee('Instructions');
        });
    }

    public function testQuizDetailsWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('quiz-details/quiz-for-php')
                ->assertSee('Instructions');
        });
    }


    public function testCategoryCoursesWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('category/1/business')
                ->assertSee('Courses');
        });
    }

    public function testCategoryCoursesWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('category/1/business')
                ->assertSee('Courses');
        });
    }


    public function testBlogsWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('blogs')
                ->assertSee('Limitless learning and more possibilities');
        });
    }

    public function testBlogsWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('blogs')
                ->assertSee('Limitless learning and more possibilities');
        });
    }

    public function testBlogsDetailsWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('blog-details/yzZ6fM')
                ->assertSee('Learn Laravel');
        });
    }

    public function testBlogsDetailsWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)->visit('blog-details/yzZ6fM')
                ->assertSee('Learn Laravel');
        });
    }

    public function testAddToCartWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('/')
                ->visit('addToCart/1')
                ->assertSee('Learn Laravel');
        });
    }

    public function testAddToCartWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(7)->visit('/')
                ->visit('addToCart/1')
                ->assertSee('Learn Laravel');
        });
    }

    public function testBuyNowWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('buyNow/1')
                ->pause(9000)
                ->assertSee('Learn Laravel');
        });
    }

    public function testBuyNowWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->loginAs(7)->visit('buyNow/11')
                ->waitForText('Your order')
                ->assertSee('Your order');
        });
    }

    public function testEnrollNowWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('buyNow/1')
                ->assertSee('Learn Laravel');
        });
    }

    public function testEnrollWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(7)->visit('buyNow/12')
                ->waitForText('Your order')
                ->assertSee('Your order');
        });
    }

    public function testMyCartWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('my-cart')
                ->assertSee('No Item found');
        });
    }

    public function testMyCartAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(7)->visit('my-cart')
                ->waitForText('My Cart')
                ->assertSee('My Cart');
        });
    }

    public function testAjaxCounterCityOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('ajaxCounterCity?id=1')
                ->assertSee('name');
        });
    }

    public function testAjaxCounterCityAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(3)->visit('ajaxCounterCity?id=1')
                ->assertSee('name');
        });
    }


    public function testRemoveToCartWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->visit('/')
                ->visit('addToCart/1')
                ->waitForText('Learn Laravel')
                ->visit('/home/removeItem/1')
                ->pause(4000)
                ->assertSee('Learn Laravel');
        });
    }

    public function testRemoveToCartWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(3)->visit('/')
                ->visit('addToCart/1')
                ->waitForText('Learn Laravel')
                ->visit('/home/removeItem/1')
                ->pause(4000)
                ->assertSee('Learn Laravel');
        });
    }

    public function testReferralCode()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/referral/123456')
                ->waitForText('Sign Up Details')
                ->assertSee('Sign Up Details');
        });
    }

    public function testFrontPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('pages/teacher-directory')
                ->assertSee('Teacher directory');
        });
    }


    public function testFrontEndSubscribe()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', 'spn19' . rand() . '@spondonit.com')
                ->click('div.footer_top_area > div > div > div:nth-child(2) > div > form > button')
                ->waitForText('Operation successful')
                ->assertSee('Operation successful');
        });
    }


    public function testCartItemList()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('getItemList')
                ->assertSee('[');
        });
    }


    public function testQuizTest()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(3)->visit('quiz-details/quiz-for-php')
                ->clickLink('Start Quiz')
                ->waitForText('Left of this Section')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->scrollIntoView("div:nth-child(10) > div > div > div > div > div > div > div > form > div")
                ->pause(3000)
                ->click('#pills-1 > ul > li:nth-child(3) > label > span.checkmark.mr_10')
                ->pause(3000)
                ->click('#next')
                ->pause(3000)
                ->click('#pills-2 > ul > li:nth-child(3) > label > span.checkmark.mr_10')
                ->pause(5000)
                ->click('#pills-2 > div.sumit_skip_btns.d-flex.align-items-center > span.theme_btn.small_btn.mr_20.next')
                ->screenshot('6')
                ->pause(3000)
                ->click('#pills-3 > ul > li:nth-child(3) > label > span.checkmark.mr_10')
                ->pause(3000)
                ->screenshot('7')
                ->click('#pills-3 > div.sumit_skip_btns.d-flex.align-items-center > span.theme_btn.small_btn.mr_20.next')
                ->pause(3000)
                ->screenshot('8')
                ->click('#pills-4 > ul > li:nth-child(3) > label > span.checkmark.mr_10')
                ->pause(3000)
                ->click('#pills-4 > div.sumit_skip_btns.d-flex.align-items-center > span.theme_btn.small_btn.mr_20.next')
                ->pause(3000)
                ->click('#pills-5 > ul > li:nth-child(3) > label > span.checkmark.mr_10')
                ->pause(3000)
                ->click('#pills-5 > div.sumit_skip_btns.d-flex.align-items-center > button')
                ->waitForText('Your Exam Score')
                ->clickLink('See Answer Sheet')
                ->waitForText('Result Sheet')
                ->assertSee('Result Sheet');
        });
    }

    public function testSubscriptionFrontPageWithOutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('course/subscription')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->pause(3000)->scrollIntoView('div.contact_section > div > div > div > div > div > div:nth-child(1) > div > div > section > div > div:nth-child(2)')
                ->click('div.contact_section > div > div > div > div > div > div:nth-child(1) > div > div > section > div > div:nth-child(2) > div:nth-child(1) > div > form > button')
                ->waitForText('You must login')
                ->assertSee('You must login');
        });
    }

    public function testSubscriptionFrontPageWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(7)
                ->visit('course/subscription')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->screenshot('next page')
                ->scrollIntoView('div.contact_section > div > div > div > div > div > div:nth-child(1) > div > div > section > div > div:nth-child(2)')
                ->click('div.contact_section > div > div > div > div > div > div:nth-child(1) > div > div > section > div > div:nth-child(2) > div:nth-child(1) > div > form > button')
                ->waitForText('Your order')
                ->click('#submitBtn')
                ->waitForText('Billing Address')
                ->click('#mainFormData > div.billing_details_wrapper > div.select_payment_method > div.privaci_polecy_area.section-padding.checkout_area > div > div > div > div > div:nth-child(6) > div > form > div > a')
                ->pause(1000)
                ->click('#infix_payment_form1 > div.modal-footer.payment_btn.d-flex.justify-content-between > button.theme_btn')
                ->waitForText('Payment done successfully')
                ->assertSee('Payment done successfully');
        });
    }


    public function testSubscriptionCoursesWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(7)
                ->visit('subscription-courses')
                ->assertSee('Subscription ');
        });
    }


    public function testCourseComment()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(1)
                ->visit('courses-details/managerial-accounting')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->pause(3000)
                ->click('#QA-tab')
                ->pause(4000)
                ->type('comment', 'this is a demo comment')
                ->pause(5000)
                ->click('#mainComment > form > div > div.col-lg-12.mb_30 > button')
                ->waitForText('Course Description')
                ->assertSee('Course Description');
        });
    }


    public function testCourseReply()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(1)
                ->visit('courses-details/managerial-accounting')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->pause(3000)
                ->click('#QA-tab')
                ->pause(3000)
                ->scrollIntoView('#QA-tab')
                ->click('#\31 _single_comment > div:nth-child(1) > div > div.comment_box_text.link > a.position_right.reply_btn.mr_20')
                ->pause(3000)
                ->type('reply', 'this is a demo reply')
                ->pause(5000)
                ->click('#\31 _single_comment > div.inputForm.comment_box_inner.comment_box_inner_reply.reply_form_1 > form > div > div.col-lg-12.mb_30 > button')
                ->waitForText('Course Description')
                ->assertSee('Course Description');
        });


    }


    public function testStudentDashboardWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('student-dashboard')
                ->assertSee('Total Spent');
        });
    }

    public function testStudentMyCourseWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('my-courses')
                ->assertSee('My Courses');
        });
    }


    public function testStudentMyQuizWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('my-quizzes')
                ->assertSee('My Quizzes');
        });
    }

    public function testStudentMyClassWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('my-classes')
                ->assertSee('Live Class');
        });
    }

    public function testStudentWishlistWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('my-wishlist')
                ->assertSee('Bookmarks');
        });
    }

    public function testStudentPurchasesWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('my-purchases')
                ->assertSee('Purchase history');
        });
    }

    public function testStudentMyProfileWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('my-profile')
                ->waitForText('My Profile')
                ->type('name', 'Student Update')
                ->type('headline', 'Student')
                ->type('address', 'Dhaka')
                ->type('zip', '1222')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->pause(3000)
                ->scrollIntoView('div.dashboard_main_wrapper > section > div:nth-child(2) > div > div > div > div > div > div.account_profile_form > form > div:nth-child(4) > div.col-12 > button')
                ->click('div.dashboard_main_wrapper > section > div:nth-child(2) > div > div > div > div > div > div.account_profile_form > form > div:nth-child(4) > div.col-12 > button')
                ->assertSee('Operation successful');
        });
    }

    public function testStudentMyAccountWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('my-account')
                ->waitForText('Account Settings')
                ->type('old_password', '12345678')
                ->type('new_password', '12345678')
                ->type('confirm_password', '12345678')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->pause(3000)
                ->scrollIntoView('div.dashboard_main_wrapper > section > div:nth-child(2) > div > div > div > div > div > div.account_profile_form > form > div > div:nth-child(5) > button')
                ->click('div.dashboard_main_wrapper > section > div:nth-child(2) > div > div > div > div > div > div.account_profile_form > form > div > div:nth-child(5) > button')
                ->waitForText('Operation successful')->assertSee('Operation successful');
        });
    }

    public function testStudentDepositWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('deposit')
                ->waitForText('Fund Deposit')
                ->type('deposit_amount', '500')
                ->click('div.dashboard_main_wrapper > section > div:nth-child(2) > div.main_content_iner > div > div > div > div > div:nth-child(2) > div > form > div > div > div > button')
                ->pause(3000)
                ->click('div.dashboard_main_wrapper > section > div:nth-child(2) > div.main_content_iner > div > div > div > div > div:nth-child(3) > div > div > div:nth-child(2) > div > div > div.single_deposite.p-0.border-0 > form > a')
                ->pause(1000)
                ->type('bank_name', 'Dhaka Bank')
                ->type('branch_name', 'Tongi Branch')
                ->type('account_number', '2323423424')
                ->type('account_holder', 'Spn19')
                ->click('#bankModel > div > div > form > div.modal-body > div:nth-child(5) > div:nth-child(1) > div')
                ->click('#bankModel > div > div > form > div.modal-body > div:nth-child(5) > div:nth-child(1) > div > ul > li:nth-child(2)')
                ->attach('image', base_path('public/assets/course/no_image.png'))
                ->click('#bankModel > div > div > form > div.modal-footer.d-flex.justify-content-between > button.theme_btn')
                ->waitForText('Your request has padding. Please wait for approved')
                ->assertSee('Your request has padding. Please wait for approved');
        });
    }

    public function testStudentLoginDeviceWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('logged-in/devices')
                ->assertSee('Logged In Devices');
        });
    }

    public function testStudentInvoiceWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('invoice/1')
                ->assertSee('PRINT');
        });
    }

    public function testStudentSubInvoiceWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('subscription-invoice/2')
                ->assertSee('INV');
        });
    }

    public function testReferralWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(3)
                ->visit('referral')
                ->assertSee('Your referral link');
        });
    }

    public function testCheckoutWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->loginAs(100)
                ->visit('/')
                ->click('#mobile-menu > li:nth-child(2) > a')
                ->waitForText('Filter Category')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->pause(3000)
                ->scrollIntoView('div:nth-child(2) > div > div > div.rating_cart > a')
                ->click('div:nth-child(2) > div > div > div.rating_cart > a')
                ->pause(3000)
                ->waitForText('Shopping Cart')
                ->pause('3000')
                ->click('div.shoping_wrapper > div.shoping_cart.active > div.view_checkout_btn.d-flex.justify-content-end.gap_10.flex-wrap > a:nth-child(1)')
                ->waitForText('My Cart')
                ->click('div.dashboard_main_wrapper > section > div:nth-child(2) > div > div > div > div > div.cart_table_wrapper.mb-0 > div > div > a')
                ->waitForText('Your order')
                ->type('code', 'save10')
                ->click('#applyCoupon')
                ->pause(3000)
                ->waitForText('Coupon Successfully Applied')
                ->click('#submitBtn')
                ->waitForText('Your order')
                ->pause(3000)
                ->click('.privaci_polecy_area.section-padding.checkout_area > div > div > div > div > div:nth-child(6) > div > form > div > a')
                ->pause(3000)
                ->click('#infix_payment_form1 > div.modal-footer.payment_btn.d-flex.justify-content-between > button.theme_btn')
                ->waitForText('Payment done successfully')
                ->assertSee('Dashboard');
        });
    }


    public function testCheckoutWithWithoutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('logout')
                ->click('#mobile-menu > li:nth-child(2) > a')
                ->waitForText('Filter Category')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->pause(3000)
                ->scrollIntoView('div > div > a > h4')
                ->click('div.rating_cart > a')
                ->pause(3000)
                ->waitForText('Shopping Cart')
                ->pause('3000')
                ->click('div.shoping_wrapper > div.shoping_cart.active > div.view_checkout_btn.d-flex.justify-content-end.gap_10.flex-wrap > a:nth-child(1)')
                ->pause(3000)
                ->waitForText('My Cart')
                ->click('.theme_btn')
                ->pause(3000)
                ->waitForText('Welcome back')
                ->assertSee('Welcome back');
        });
    }

    public function testCourseDetailsFullScreenWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(3)->visit('courses-details/managerial-accounting')
                ->pause(3000)
                ->click('div.theme_cookies > button')
                ->pause(3000)
                ->click('#Curriculum-tab')
                ->scrollIntoView('#Curriculum-tab')
                ->scrollIntoView('#heading1 > h5 > button')
                ->pause(3000)
                ->click('#heading1 > h5 > button')
                ->pause(3000)
                ->click('#collapse1 > div > div > div:nth-child(4) > div.curriculam_right > a')
                ->pause(3000)
                ->scrollIntoView('div.course_fullview_wrapper > div > div.course__play_list > div:nth-child(10) > a > div > label > span')
                ->click('div.course_fullview_wrapper > div > div.course__play_list > div:nth-child(10) > a > div > label > span')
                ->pause(3000)
//                ->waitForText(  'Get Certificate')
                ->click('div.course_fullview_wrapper > div > div.course__play_list > div:nth-child(10) > a')
                ->pause(3000)
                ->waitForText('Get Certificate')
                ->assertSee('Get Certificate');
        });
    }
}
