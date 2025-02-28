<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                @if($avatar = \Auth::user()->avatar ?? null)
                    <img src="{{ $avatar['url'] }}" style="border-radius: 50%;height: 45px;width: 45px;" alt="User Image">
                @else
                    <img src="{{ customAsset('assets/admin/dist/img/no-image.gif') }}" style="border-radius: 50%;height: 45px;width: 45px;" alt="User Image">
                @endif
            </div>
            <div class="pull-left info">
                <p>{{ \Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        {{--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>--}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            {{--<li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Layout Options</span>
                    <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                    <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                    <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                    <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                </ul>
            </li>
            <li>
                <a href="pages/widgets.html">
                    <i class="fa fa-th"></i> <span>Widgets</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
                </a>
            </li>--}}
            {{--<li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                <a href="{{ route('admin.user.list') }}">
                    <i class="fa fa-users"></i> <span>Khách hàng</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/contacts*') ? 'active' : '' }}">
                <a href="{{ route('admin.contact.list') }}">
                    <i class="fa fa-envelope"></i> <span>Liên hệ</span>
                    <span class="pull-right-container count-unread-contact">
                        @php
                            $count = resolve(\App\Services\Admin\Contact\CountUnreadService::class)->handle()
                        @endphp
                        <small class="label pull-right bg-red">{{ $count ? $count : null }}</small>
                    </span>
                </a>
            </li>

            <li class="{{ request()->is('admin/sliders*') ? 'active' : '' }}">
                <a href="{{ route('admin.main-banner.list') }}">
                    <i class="fa fa-sliders"></i> <span>Quản lý banners</span>
                </a>
            </li>--}}

{{--            <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}">--}}
{{--                <a href="{{ route('admin.category.list') }}">--}}
{{--                    <i class="fa fa-list-ul"></i> <span>Danh mục sản phẩm</span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li class="{{ request()->is('admin/products*') ? 'active' : '' }}">--}}
{{--                <a href="{{ route('admin.product.list') }}">--}}
{{--                    <i class="fa fa-product-hunt"></i> <span>Sản phẩm</span>--}}
{{--                </a>--}}
{{--            </li>--}}

           {{-- <li class="treeview {{ request()->is('admin/categories*') || request()->is('admin/products*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-product-hunt"></i> <span>Quản lý sản phẩm</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                        <a href="{{ route('admin.category.list') }}">
                            <i class="fa fa-list-alt"></i> <span>Danh mục sản phẩm</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                        <a href="{{ route('admin.product.list') }}">
                            <i class="fa fa-book"></i> <span>Sản phẩm</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                <a href="{{ route('admin.order.list') }}">
                    <i class="fa fa-shopping-cart"></i> <span>Đơn hàng</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/discounts*') ? 'active' : '' }}">
                <a href="{{ route('admin.discount.list') }}">
                    <i class="fa fa-percent"></i> <span>Giảm giá</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/fee-charge*') ? 'active' : '' }}">
                <a href="{{ route('admin.fee_charge.index') }}">
                    <i class="fa fa-usd"></i> <span>Phụ phí</span>
                </a>
            </li>--}}

            <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                <a href="{{ route('admin.category.index') }}">
                    {{-- <i class="fa fa-thumb-tack" aria-hidden="true"></i> --}}
                    <span>Danh mục sản phẩm</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/categories1*') ? 'active' : '' }}">
                <a href="{{ route('admin.category.index') }}">
                    {{-- <i class="fa fa-thumb-tack" aria-hidden="true"></i> --}}
                    <span>Sản phẩm</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/categories2*') ? 'active' : '' }}">
                <a href="{{ route('admin.category.index') }}">
                    {{-- <i class="fa fa-thumb-tack" aria-hidden="true"></i> --}}
                    <span>Đơn hàng</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/categor2ies*') ? 'active' : '' }}">
                <a href="{{ route('admin.category.index') }}">
                    {{-- <i class="fa fa-thumb-tack" aria-hidden="true"></i> --}}
                    <span>Trang</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/catego1ries*') ? 'active' : '' }}">
                <a href="{{ route('admin.category.index') }}">
                    {{-- <i class="fa fa-thumb-tack" aria-hidden="true"></i> --}}
                    <span>Danh mục bài viết</span>
                </a>
            </li>


            <li class="{{ request()->is('admin/categ1ories*') ? 'active' : '' }}">
                <a href="{{ route('admin.category.index') }}">
                    {{-- <i class="fa fa-thumb-tack" aria-hidden="true"></i> --}}
                    <span>Bài viết</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/categ5ories*') ? 'active' : '' }}">
                <a href="{{ route('admin.category.index') }}">
                    {{-- <i class="fa fa-thumb-tack" aria-hidden="true"></i> --}}
                    <span>Quản trị viên</span>
                </a>
            </li>





            {{-- <li class="treeview {{ request()->is('admin/posts*') || request()->is('admin/categories*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Quản lý bài viết</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                        <a href="{{ route('admin.category.list') }}">
                            <i class="fa fa-list-alt"></i> <span>Danh mục bài viết</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('admin/posts*') ? 'active' : '' }}">
                        <a href="{{ route('admin.post.list') }}">
                            <i class="fa fa-book"></i> <span>Bài viết</span>
                        </a>
                    </li>
                </ul>
            </li> --}}

            {{--<li class="{{ request()->is('admin/post-comments*') ? 'active' : '' }}">
                <a href="{{ route('admin.post_comment.list') }}">
                    <i class="fa fa-comments"></i> <span>Bình luận bài viết</span>
                    <span class="pull-right-container count-comment-post">
                        @php
                            $count = resolve(\App\Services\Admin\Comment\CountCommentService::class)->handle(\App\Models\Post::class)
                        @endphp
                        <small class="label pull-right bg-red">{{ $count ? $count : null }}</small>
                    </span>
                </a>
            </li>--}}


{{--            <li class="treeview {{ request()->is('admin/document-categories*') || request()->is('admin/documents*') ? 'active' : '' }}">--}}
{{--                <a href="#">--}}
{{--                    <i class="fa fa-edit"></i> <span>Quản lý tài liệu</span>--}}
{{--                    <span class="pull-right-container">--}}
{{--              <i class="fa fa-angle-left pull-right"></i>--}}
{{--            </span>--}}
{{--                </a>--}}
{{--                <ul class="treeview-menu">--}}
{{--                    <li class="{{ request()->is('admin/document-categories*') ? 'active' : '' }}">--}}
{{--                        <a href="{{ route('admin.document_category.list') }}">--}}
{{--                            <i class="fa fa-list-ul"></i> <span>Danh mục tài liệu</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="{{ request()->is('admin/documents*') ? 'active' : '' }}">--}}
{{--                        <a href="{{ route('admin.document.list') }}">--}}
{{--                            <i class="fa fa-file"></i> <span>Tài liệu</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="{{ request()->is('admin/courses*') ? 'active' : '' }}">--}}
{{--                <a href="{{ route('admin.course.list') }}">--}}
{{--                    <i class="fa fa-graduation-cap"></i> <span>Khóa học</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            {{-- <li class="{{ request()->is('admin/pages*') ? 'active' : '' }}">
                <a href="{{ route('admin.page.list') }}">
                    <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                    <span>Trang</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/main-banners*') ? 'active' : '' }}">
                <a href="{{ route('admin.main_banner.list') }}">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    <span>Quản lý Banner</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/course-images*') ? 'active' : '' }}">
                <a href="{{ route('admin.course_image.list') }}">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    <span>Hình ảnh khóa học</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/support-and-consultation*') ? 'active' : '' }}">
                <a href="{{ route('admin.consultation.list') }}">
                    <i class="fa fa-question" aria-hidden="true"></i>
                    <span>Hỗ trợ & tư vấn</span>
                </a>
            </li> --}}


  {{--          <li class="{{ request()->is('admin/comments*') ? 'active' : '' }}">
                <a href="{{ route('admin.comment.list') }}">
                    <i class="fa fa-comments-o"></i> <span>Bình luận</span>
                    <span class="pull-right-container count-comment">
                        @php
                            $count = resolve(\App\Services\Admin\Comment\CountCommentService::class)->handle()
                        @endphp
                        <small class="label pull-right bg-red">{{ $count ?: null }}</small>
                    </span>
                </a>
            </li>--}}

            {{--<li class="{{ request()->is('admin/calendars*') ? 'active' : '' }}">
                <a href="{{ route('admin.calendar.list') }}">
                    <i class="fa fa-calendar-plus-o"></i> <span>Calendar</span>
                </a>
            </li>--}}

{{--            <li>--}}
{{--                @if($appId = getWebsiteSetting('fb_comment_app_id')->fb_comment_app_id ?? null)--}}
{{--                <a target="_blank" href="{{ "https://developers.facebook.com/tools/comments/{$appId}" }}">--}}
{{--                    <i class="fa fa-facebook"></i> <span>Bình luận Facebook</span>--}}
{{--                </a>--}}
{{--                @endif--}}
{{--            </li>--}}

            {{-- <li class="{{ request()->is('admin/admins*') ? 'active' : '' }}">
                <a href="{{ route('admin.admins.list') }}">
                    <i class="fa fa-users"></i> <span>Quản lý admin</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/request-logs*') ? 'active' : '' }}">
                <a href="{{ route('admin.request_log.list') }}">
                    <i class="fa fa-history" aria-hidden="true"></i>
                    <span>Lịch sử truy cập</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/main-menu') ? 'active' : '' }}">
                <a href="{{ route('admin.main_menu.index') }}">
                    <i class="fa fa-fw fa-gears"></i> <span>Thiết lập menu chính</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/website-setting*') ? 'active' : '' }}">
                <a href="{{ route('admin.website_setting.edit') }}">
                    <i class="fa fa-fw fa-gears"></i> <span>Cài đặt</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/logs*') ? 'active' : '' }}">
                <a href="{{ route('admin.log.index') }}">
{{--                    <i class="fa fa-fw fa-gears"></i>--}}
                    <span>Logs</span>
                </a>
            </li> --}}

            {{--<li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Charts</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                    <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                    <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                    <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>UI Elements</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                    <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                    <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                    <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                    <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                    <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Forms</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i> <span>Tables</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                    <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
                </ul>
            </li>
            <li>
                <a href="pages/calendar.html">
                    <i class="fa fa-calendar"></i> <span>Calendar</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
                </a>
            </li>
            <li>
                <a href="pages/mailbox/mailbox.html">
                    <i class="fa fa-envelope"></i> <span>Mailbox</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Examples</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                    <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                    <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                    <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                    <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                    <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                    <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                    <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                    <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Multilevel</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Level One
                            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-circle-o"></i> Level Two
                                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                </ul>
            </li>
            <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
