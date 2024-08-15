  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
  <script src="{{ asset('assets/js/waves.min.js') }}"></script>

  <script src="{{ asset('dashboard/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/tinymce/tinymce.min.js')}}"></script>

  <script src="{{ asset('assets/js/app.js') }}"></script>

  <!-- Required datatable js -->
  <script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <!-- Buttons examples -->
  <script src="{{ asset('dashboard/plugins/datatables/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/datatables/jszip.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/datatables/pdfmake.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/datatables/vfs_fonts.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/datatables/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/datatables/buttons.print.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/datatables/buttons.colVis.min.js') }}"></script>
  <!-- Responsive examples -->
  <script src="{{ asset('dashboard/plugins/datatables/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('dashboard/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

  <!-- Datatable init js -->
  <script src="{{ asset('assets/pages/datatables.init.js') }}"></script>

  <!-- Parsley js -->
  <script src="{{ asset('dashboard/plugins/parsleyjs/parsley.min.js') }}"></script>

  <!--Morris Chart-->
  {{-- <script src="{{ asset('dashboard/plugins/morris/morris.min.js') }}"></script> --}}
  <script src="{{ asset('dashboard/plugins/raphael/raphael-min.js') }}"></script>
  {{-- <script src="{{ asset('dashboard/pages/dashboard.js') }}"></script> --}}

  <script src="{{ asset('dashboard/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

  <!-- Responsive-table-->
  <script src="{{ asset('dashboard/plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js')}}"></script>

  <script>
      $(function() {
          $('.table-responsive').responsiveTable({
              addDisplayAllBtn: 'btn btn-secondary'
          });
      });
  </script>

  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').parsley();
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            if ($("#deskripsi").length > 0) {
                tinymce.init({
                    selector: "textarea#deskripsi",
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                            title: 'Bold text',
                            inline: 'b'
                        },
                        {
                            title: 'Red text',
                            inline: 'span',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Red header',
                            block: 'h1',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Example 1',
                            inline: 'span',
                            classes: 'example1'
                        },
                        {
                            title: 'Example 2',
                            inline: 'span',
                            classes: 'example2'
                        },
                        {
                            title: 'Table styles'
                        },
                        {
                            title: 'Table row 1',
                            selector: 'tr',
                            classes: 'tablerow1'
                        }
                    ]
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            if ($("#kualifikasi").length > 0) {
                tinymce.init({
                    selector: "textarea#kualifikasi",
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                            title: 'Bold text',
                            inline: 'b'
                        },
                        {
                            title: 'Red text',
                            inline: 'span',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Red header',
                            block: 'h1',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Example 1',
                            inline: 'span',
                            classes: 'example1'
                        },
                        {
                            title: 'Example 2',
                            inline: 'span',
                            classes: 'example2'
                        },
                        {
                            title: 'Table styles'
                        },
                        {
                            title: 'Table row 1',
                            selector: 'tr',
                            classes: 'tablerow1'
                        }
                    ]
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            if ($("#aktivitas").length > 0) {
                tinymce.init({
                    selector: "textarea#aktivitas",
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                            title: 'Bold text',
                            inline: 'b'
                        },
                        {
                            title: 'Red text',
                            inline: 'span',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Red header',
                            block: 'h1',
                            styles: {
                                color: '#ff0000'
                            }
                        },
                        {
                            title: 'Example 1',
                            inline: 'span',
                            classes: 'example1'
                        },
                        {
                            title: 'Example 2',
                            inline: 'span',
                            classes: 'example2'
                        },
                        {
                            title: 'Table styles'
                        },
                        {
                            title: 'Table row 1',
                            selector: 'tr',
                            classes: 'tablerow1'
                        }
                    ]
                });
            }
        });
    </script>
