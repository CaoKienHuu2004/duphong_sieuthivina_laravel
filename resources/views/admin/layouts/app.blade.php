<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=0"
    />
    <meta name="description" content="Quản trị hệ thống Siêu Thị Vina" />
    <meta
      name="keywords"
      content="Siêu Thị Vina, quản trị hệ thống, quản lý siêu thị, quản lý bán hàng"
    />
    <meta name="author" content="Quản Trị Viên"/>
    <meta name="robots" content="noindex, nofollow"/>
    <title>@yield('title', 'Quản trị hệ thống Siêu Thị Vina')</title>

    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="{{asset('assets/client/images/logo/icon_nguyenban.png')}}"
    />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/admin/css/animate.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/admin/css/dataTables.bootstrap4.min.css')}}" />
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/assets/admin/css/jquery.dataTables.min.css"> -->

    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/dragula/css/dragula.min.css') }}" />

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/46.0.2/ckeditor5.css" crossorigin>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="{{asset('assets/admin/plugins/select2/css/select2.min.css')}}" />

    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/owlcarousel/owl.carousel.min.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/lightbox/glightbox.min.css') }}" />

    <link
      rel="stylesheet"
      href="{{asset('assets/admin/plugins/fontawesome/css/fontawesome.min.css')}}"
    />
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/fontawesome/css/all.min.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}" />
  </head>
  <body>
    <!-- <div id="global-loader">
      <div class="whirly-loader"></div>
    </div> -->

    <div class="main-wrapper">
      <div class="header">
            <div class="header-left active">
                <a href="https://sieuthivina.shop" class="logo">
                    <img src="{{asset('assets/client')}}/images/logo/logo_nguyenban.png" alt style="width: 65%" />
                </a>
                <a href="https://sieuthivina.shop" class="logo-small">
                    <img src="{{asset('assets/client')}}/images/logo/logo_nguyenban.png" alt style="width: 60%" />
                </a>
                <a id="toggle_btn" href="javascript:void(0);"> </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">
              @php
                                $donHangCho = $donhangs->where('trangthai', 'Chờ xác nhận');
                            @endphp
                <li class="nav-item dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <img src="{{asset('assets/admin')}}/img/icons/notification-bing.svg" alt="img" />
                        <span class="badge rounded-pill @if($donHangCho->count() > 0) blinking-flash @endif)">{{ $donHangCho->count() }}</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title fw-bold">Thông báo</span>
                            <a href="{{ route('quan-tri-vien.danh-sach-don-hang') }}" class="clear-noti">
                                xem tất cả </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                              {{-- BƯỚC 1: Tạo biến chứa danh sách đã lọc --}}
                            
                            @if($donHangCho->count() > 0)
                              @foreach ( $donHangCho as $donhang)
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details">
                                                    <span class="noti-title">{{ $donhang->nguoinhan }}</span> added new task
                                                    <span class="noti-title">Patient appointment booking</span>
                                                </p>
                                                <p class="noti-time">
                                                    <span class="notification-time">4 phút trước</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                              @endforeach
                              @else
                              <li class="notification-message">
                                  <div class="media d-flex justify-content-center p-3">
                                      <span>Không có đơn hàng chờ xác nhận</span>
                                  </div>
                              </li>
                              @endif
                                
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="{{asset('assets/client')}}/images/thumbs/{{ Auth::user()->avatar }}" alt />
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="{{asset('assets/client')}}/images/thumbs/{{ Auth::user()->avatar }}" alt />
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ Auth::user()->hoten }}</h6>
                                    <h5>Quản trị viên</h5>
                                </div>
                            </div>
                            <hr class="m-0" />
                            <a class="dropdown-item" href="profile.html">
                                <i class="me-2" data-feather="user"></i>
                                Thông tin cá nhân</a>
                            <a class="dropdown-item" href="https://sieuthivina.com">
                                <i class="me-2" data-feather="globe"></i>Sieuthivina.com</a>
                            <hr class="m-0" />
                            <a class="dropdown-item logout pb-0" href="signin.html"><img
                                    src="{{asset('assets/admin')}}/img/icons/log-out.svg" class="me-2" alt="img" />Đăng xuất</a>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">Thông tin
                        cá nhân</a>
                    <a class="dropdown-item" href="https://sieuthivina.com">Sieuthivina.com</a>
                    <a class="dropdown-item" href="signin.html">Đăng
                        xuất</a>
                </div>
            </div>
        </div>

      <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="{{ request()->routeIs('quan-tri-vien.trang-chu') ? 'active' : '' }}">
                            <a href="{{ route('quan-tri-vien.trang-chu') }}"><i data-feather="home"></i>
                                <span>Tổng quan</span>
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="package"></i><span>
                                    Sản phẩm</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="{{ request()->routeIs('quan-tri-vien.danh-sach-san-pham') ? 'active' : '' }}" href="{{ route('quan-tri-vien.danh-sach-san-pham') }}">Danh sách sản phẩm</a></li>
                                <li><a class="{{ request()->routeIs('quan-tri-vien.danh-sach-danh-muc') ? 'active' : '' }}" href="{{ route('quan-tri-vien.danh-sach-danh-muc') }}">Danh mục sản phẩm</a></li>
                                <li><a class="{{ request()->routeIs('quan-tri-vien.danh-sach-thuong-hieu') ? 'active' : '' }}" href="{{ route('quan-tri-vien.danh-sach-thuong-hieu') }}">Thương hiệu sản phẩm</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="shopping-cart"></i>
                                <span>Bán hàng 
                                  @if($donhangs->where('trangthai','Chờ xác nhận')->count() > 0)
                                    <span class="bg-danger text-white px-2 py-1 rounded-circle blinking-flash">!</span>
                                  @endif
                                </span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <!-- <li><a href="saleslist.html">Xác nhận thanh toán<span class="bg-warning text-white px-2 py-1 rounded-circle">4</span></a></li> -->
                                <li><a href="{{ route('quan-tri-vien.danh-sach-don-hang') }}">Danh sách đơn hàng @if($donhangs->where('trangthai','Chờ xác nhận')->count() > 0)
                                    <span class="bg-warning text-white px-2 py-1 rounded-circle blinking-flash">!</span>
                                  @endif</a></li>

                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="award"></i><span>
                                    Ưu đãi & quà tặng</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="{{ request()->routeIs('quan-tri-vien.danh-sach-ma-giam-gia') ? 'active' : '' }}" href="{{ route('quan-tri-vien.danh-sach-ma-giam-gia') }}">Mã giảm giá</a></li>
                                <li><a class="{{ request()->routeIs('quan-tri-vien.danh-sach-qua-tang') ? 'active' : '' }}" href="{{ route('quan-tri-vien.danh-sach-qua-tang') }}">Chương trình quà tặng ưu đãi</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="users"></i><span>
                                    Người dùng</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="{{ request()->routeIs('quan-tri-vien.danh-sach-nguoi-dung') ? 'active' : '' }}" href="{{ route('quan-tri-vien.danh-sach-nguoi-dung') }}">Danh sách người dùng</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('quan-tri-vien.danh-sach-thong-bao') ? 'active' : '' }}" href="{{ route('quan-tri-vien.danh-sach-thong-bao') }}"><i data-feather="bell"></i><span>
                                    Gửi thông báo</span>
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="layout"></i><span>
                                    Tùy chỉnh website</span>
                                <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a class="{{ request()->routeIs('quan-tri-vien.danh-sach-trang-don') ? 'active' : '' }}" href="{{ route('quan-tri-vien.danh-sach-trang-don') }}">Trang nội dung</a></li>
                                <li><a class="{{ request()->routeIs('quan-tri-vien.danh-sach-banner-quang-cao') ? 'active' : '' }}" href="{{ route('quan-tri-vien.danh-sach-banner-quang-cao') }}">Banner quảng cáo</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

         @yield('content')

    </div>


    <script src="{{asset('assets/admin/js/jquery-3.6.0.min.js')}}"></script>

    <script src="{{asset('assets/admin/js/feather.min.js')}}"></script>

    <script src="{{asset('assets/admin/js/jquery.slimscroll.min.js')}}"></script>

    <script src="{{asset('assets/admin/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="{{asset('assets/admin/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/admin/plugins/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugins/apexchart/chart-data.js')}}"></script>

    <script src="{{asset('assets/admin/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/custom-select.js') }}"></script>

    <script src="{{asset('assets/admin/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugins/sweetalert/sweetalerts.min.js')}}"></script>

    <script src="{{ asset('assets/admin/plugins/dragula/js/dragula.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/dragula/js/drag-drop.min.js') }}"></script>

    <script src="{{asset('assets/admin/plugins/fileupload/fileupload.min.js')}}"></script>

    <script src="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/owlcarousel/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/lightbox/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/lightbox/lightbox.js') }}"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/46.0.2/ckeditor5.umd.js" crossorigin></script>
		<script src="https://cdn.ckeditor.com/ckeditor5/46.0.2/translations/vi.umd.js" crossorigin></script>

    <script src="{{asset('assets/admin/js/script.js')}}"></script>
    <script>
      /**
        * This configuration was generated using the CKEditor 5 Builder. You can modify it anytime using this link:
        * https://ckeditor.com/ckeditor-5/builder/?redirect=portal#installation/NoNgNARATAdA7DAzBSU5RAFgIwAZeYCcucAHNnAKzoXG6mlyGam6FSVQOUgoQBuASxS4wwbGFGiJ0gLqQApgEMARriVLCEWUA===
        */

        const {
          ClassicEditor,
          Alignment,
          AutoImage,
          AutoLink,
          Autosave,
          BlockQuote,
          Bold,
          Bookmark,
          Code,
          CodeBlock,
          Essentials,
          FindAndReplace,
          FontBackgroundColor,
          FontColor,
          FontFamily,
          FontSize,
          GeneralHtmlSupport,
          Heading,
          Highlight,
          HorizontalLine,
          ImageBlock,
          ImageCaption,
          ImageInsert,
          ImageInsertViaUrl,
          ImageToolbar,
          ImageUpload,
          Indent,
          IndentBlock,
          Italic,
          Link,
          LinkImage,
          MediaEmbed,
          Paragraph,
          PasteFromOffice,
          RemoveFormat,
          SimpleUploadAdapter,
          SpecialCharacters,
          SpecialCharactersArrows,
          SpecialCharactersCurrency,
          SpecialCharactersEssentials,
          SpecialCharactersLatin,
          SpecialCharactersMathematical,
          SpecialCharactersText,
          Strikethrough,
          Style,
          Subscript,
          Superscript,
          Table,
          TableCaption,
          TableCellProperties,
          TableColumnResize,
          TableProperties,
          TableToolbar,
          TextPartLanguage,
          Underline,
          WordCount
        } = window.CKEDITOR;

        const LICENSE_KEY =
          'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3OTcyOTI3OTksImp0aSI6ImYzMTc0OGExLWI0MTUtNGNhMS04MzcyLTNlOWUxYTI2MjIxMCIsImxpY2Vuc2VkSG9zdHMiOlsic2lldXRoaXZpbmEuY29tIl0sInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCIsIkUyUCIsIkUyVyJdLCJ2YyI6IjYyOWEwNWE3In0.azrlhSGtxhZ6CppYF0mej-jpibqJJgARkTPddO1EZXclKcj8ZGSbi-8Yw9qZhLUv0aiRLt6bMuG-60yytWgYzA';

        const editorConfig = {
          toolbar: {
            items: [
              'undo',
              'redo',
              '|',
              'findAndReplace',
              'textPartLanguage',
              '|',
              'heading',
              'style',
              '|',
              'fontSize',
              'fontFamily',
              'fontColor',
              'fontBackgroundColor',
              '|',
              'bold',
              'italic',
              'underline',
              'strikethrough',
              'subscript',
              'superscript',
              'code',
              'removeFormat',
              '|',
              'specialCharacters',
              'horizontalLine',
              'link',
              'bookmark',
              'insertImage',
              'MediaEmbed',
              'insertTable',
              'highlight',
              'blockQuote',
              'codeBlock',
              '|',
              'alignment',
              '|',
              'outdent',
              'indent'
            ],
            shouldNotGroupWhenFull: false
          },
          plugins: [
            Alignment,
            AutoImage,
            AutoLink,
            Autosave,
            BlockQuote,
            Bold,
            Bookmark,
            Code,
            CodeBlock,
            Essentials,
            FindAndReplace,
            FontBackgroundColor,
            FontColor,
            FontFamily,
            FontSize,
            GeneralHtmlSupport,
            Heading,
            Highlight,
            HorizontalLine,
            ImageBlock,
            ImageCaption,
            ImageInsert,
            ImageInsertViaUrl,
            ImageToolbar,
            ImageUpload,
            MediaEmbed,
            Indent,
            IndentBlock,
            Italic,
            Link,
            LinkImage,
            Paragraph,
            PasteFromOffice,
            RemoveFormat,
            SimpleUploadAdapter,
            SpecialCharacters,
            SpecialCharactersArrows,
            SpecialCharactersCurrency,
            SpecialCharactersEssentials,
            SpecialCharactersLatin,
            SpecialCharactersMathematical,
            SpecialCharactersText,
            Strikethrough,
            Style,
            Subscript,
            Superscript,
            Table,
            TableCaption,
            TableCellProperties,
            TableColumnResize,
            TableProperties,
            TableToolbar,
            TextPartLanguage,
            Underline,
            WordCount
          ],
          mediaEmbed: {
            previewsInData: true
        },
          fontFamily: {
            supportAllValues: true
          },
          fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 22],
            supportAllValues: true
          },
          heading: {
            options: [
              {
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
              },
              {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
              },
              {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
              },
              {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
              },
              {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
              },
              {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
              },
              {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
              }
            ]
          },
          htmlSupport: {
            allow: [
              {
                name: /^.*$/,
                styles: true,
                attributes: true,
                classes: true
              }
            ]
          },
          image: {
            toolbar: ['toggleImageCaption']
          },
          language: 'vi',
          licenseKey: LICENSE_KEY,
          link: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            decorators: {
              toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                  download: 'file'
                }
              }
            }
          },
          placeholder: 'Type or paste your content here!',
          style: {
            definitions: [
              {
                name: 'Article category',
                element: 'h3',
                classes: ['category']
              },
              {
                name: 'Title',
                element: 'h2',
                classes: ['document-title']
              },
              {
                name: 'Subtitle',
                element: 'h3',
                classes: ['document-subtitle']
              },
              {
                name: 'Info box',
                element: 'p',
                classes: ['info-box']
              },
              {
                name: 'CTA Link Primary',
                element: 'a',
                classes: ['button', 'button--green']
              },
              {
                name: 'CTA Link Secondary',
                element: 'a',
                classes: ['button', 'button--black']
              },
              {
                name: 'Marker',
                element: 'span',
                classes: ['marker']
              },
              {
                name: 'Spoiler',
                element: 'span',
                classes: ['spoiler']
              }
            ]
          },
          table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
          }
        };

        ClassicEditor.create(document.querySelector('#editor'), editorConfig).then(editor => {
          const wordCount = editor.plugins.get('WordCount');
          document.querySelector('#editor-word-count').appendChild(wordCount.wordCountContainer);

          return editor;
        });

    </script>
    @yield('scripts')
  </body>
</html>
