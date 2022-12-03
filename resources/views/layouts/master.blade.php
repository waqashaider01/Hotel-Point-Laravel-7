<!DOCTYPE html>
<html lang="en">
<head>
    <base href="">
    <meta charset="utf-8" />
    <title>@yield('title', 'HotelPoint PMS')</title>
    <meta name="description" content="HotelPoint PMS" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicon data -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    {{-- global --}}
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    {{-- global --}}
    <link href="{{ asset('css/headerstyle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/mylist.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{asset('css/app2.css')}}" rel="stylesheet" type="text/css"/> --}}
    <link href="{{ asset('plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <style>
        body {
            padding: 0 !important;
        }
        .scrolltop {
            z-index: 10000 !important;
        }
        .ql-editor {
            min-height: 300px;
        }
        .ql-snow .ql-color-picker .ql-picker-label, .ql-snow .ql-icon-picker .ql-picker-label {
            padding: 1px;
            top: -4px;
        }

        .full-page-loader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            z-index: 99999999;
            background: rgb(238, 238, 238, 0.75);
            display: none;
            justify-content: center;
            align-items: center;
        }
    </style>
    @stack('styles')
    @include('sweetalert::alert')
    @livewireStyles
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
</head>

<body id="kt_body">
    @include('layouts.header')
    <div class="flex-column-fluid">
        @yield('content')
    </div>
    @include('layouts.footer')
    {{-- <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.0.3/dist/perfect-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.6.0/build/highlight.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/widgets.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('js/kindEditor-min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"
            referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const csrf_token = $('meta[name="csrf-token"]').attr('content')
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf_token
            }
        });
        let quill_editor;

        const QUILL_TOOLBAR_OPTIONS = [
            [{ 'font': [] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false]}],
            [{ 'align': '' }, { 'align': 'center' }, { 'align': 'right' }],

            ['bold', 'italic', 'underline', 'strike'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['blockquote', 'code-block'],

            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],

            [{'color': []}],
            ['clean']
        ];

        const QUILL_OPTIONS = {
            modules: {
                syntax: true,
                toolbar: QUILL_TOOLBAR_OPTIONS,
            },
            placeholder: 'Start Typing...',
            theme: 'snow'
        };
    </script>
    @livewireScripts
    @stack('scripts')
    <script>
        $(document).ready(function() {
            @if (session()->has('success'))
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    timer: 2000
                })
            @endif
            @if (session()->has('error'))
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('error') }}',
                    timer: 2000
                })
            @endif
            window.livewire.on('dataSaved', (message) => {
                $('.modal').modal('hide')
                $('.modal-backdrop').remove()
                Swal.fire({
                    icon: 'success',
                    title: message,
                    timer: 2000
                })
            });
            window.livewire.on('windowReload', () => {
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            });
            window.livewire.on('loading', (load = true) => {
                console.log("Loading", load);
                if (load) {
                    console.log("Loading Fired");
                    Swal.fire({
                        icon: 'info',
                        title: "",
                        timer: 200000,
                        html: `
                            <h4>Working on your request</h4>
                        `,
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                    Swal.enableLoading();
                } else {
                    Swal.close();
                }
            });

            window.livewire.on('success', (message, modelId = ".modal") => {
                $(modelId).modal('hide');
                $('.modal-backdrop').remove();
                Swal.fire({
                    icon: 'success',
                    title: message,
                    timer: 2000
                })
            });
            window.livewire.on('error', (message, modelId = ".modal") => {
                $(modelId).modal('hide');
                $('.modal-backdrop').remove();
                Swal.fire({
                    icon: 'error',
                    title: message,
                    timer: 2000
                })
            });
            window.livewire.on('hideModal', (modelId = ".modal") => {
                $(modelId).modal('hide');
                $('.modal-backdrop').remove();
            });
            window.livewire.on('showModal', (modelId = ".modal", runScript = false) => {
                console.log(modelId);
                $(modelId).modal('show');
                if (runScript) {
                    $(document.getElementById("selected_company.country")).select2()
                }
            });
            window.livewire.on('confirmDelete', () => {
                Swal.fire({
                    title: 'Are you sure you want to delete this record?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        window.livewire.emit('deleteItem');
                    }
                })
            });
            window.livewire.on('showWarning', (text) => {
                Swal.fire(
                    'Info',
                    text,
                    'info'
                )
            });
        });
        window.livewire.on('showWarning', (text) => {
            Swal.fire(
                'Info',
                text,
                'info'
            )
        });
        window.livewire.on('showError', (text) => {
            Swal.fire({
                title: "There was an error!",
                text: text,
                icon: 'warning',
                dangerMode: true,
            });
        });

        window.livewire.on('updateFlatPicker', function(selector, date, format, triggerChange=false){
            const inputField = document.querySelector(selector);
            if(!inputField){
                console.error(`Element not found against the provided selector: ${selector}`);
                return;
            }
            const fp = flatpickr(inputField, {});
            fp.setDate(date, triggerChange, format);
            fp.set('dateFormat', format);
        });

        window.livewire.on('showSwal', (title, text, icon, timer=null) => {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                timer: timer,
            });
        });

        window.livewire.on('initTooltip', () => {
            $('[data-toggle="tooltip"]').tooltip();
        });

        window.livewire.on('changeCollapse', (selector, method) => {
            $(selector).collapse(method);
        });

        window.livewire.on('initQuillReadOnly', (selector, content = "", options = {}) => {
            new Quill('#template', {...QUILL_OPTIONS, readOnly: true, ...options});
        });

        window.livewire.on('initQuill', (selector, content = "", options = {}, focus = true) => {
            let editor = new Quill(selector, {...QUILL_OPTIONS, ...options});
            editor.root.innerHTML = content;

            if(focus){
                editor.focus();
            }

            const EDITOR_CONTAINER = document.querySelector(selector);

            let livewireInput = document.querySelector(EDITOR_CONTAINER.getAttribute('data-livewire-input'));
            if(livewireInput){
                editor.on('text-change', function(delta, oldDelta, source) {
                    if(editor.root.innerHTML !== "<p><br></p>"){
                        livewireInput.value =  editor.root.innerHTML;
                    } else {
                        livewireInput.value = '';
                    }

                    livewireInput.dispatchEvent(new Event('input'));
                });
            }
        });
    </script>
    @if (Session::has('message'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: "{{ Session::get('alert-class') }}",
                    text: "{{ Session::get('message') }}"

                })
            });
        </script>
        @php Session::forget('message') @endphp
    @endif
</body>

</html>
