@if (backpack_auth()->check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        @include('backpack::inc.sidebar_user_panel')

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <div class="sidebar-form" style="position: relative; overflow: unset;">
          <div class="input-group">
            <input type="text" name="q" id="search_sidebar" class="form-control" placeholder="Search..." autocomplete="off">
            <span class="input-group-btn">
              <a href="javascript:void(0)" name="search" class="btn btn-flat">
                <i class="fa fa-search"></i>
              </a>
            </span>
            <ul class="search-results">
              {{-- <li><a href="index.html">Search Result #1<br /><span>Description...</span></a></li> --}}
            </ul>
          </div>

          {{-- <div class="search-content" > --}}

          {{-- </div> --}}
        </div>

        <ul class="sidebar-menu" data-widget="tree">
          {{-- <li class="header">{{ trans('backpack::base.administration') }}</li> --}}
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
         
          @if(env('ROLES_PERMISSIONS'))
            @include('backpack::inc.sidebar_content_with_roles_permissions')
          @else
            @include('backpack::inc.sidebar_content')
          @endif
          <!-- ======================================= -->
          {{-- <li class="header">Other menus</li> --}}
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
