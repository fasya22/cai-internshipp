  <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/js/metisMenu.min.js') }}"></script>
  <script src="{{ asset('admin/js/jquery.slimscroll.js') }}"></script>
  <script src="{{ asset('admin/js/waves.min.js') }}"></script>

  <script src="{{ asset('admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/parsleyjs/parsley.min.js') }}"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

  <!-- Jquery-Ui -->
  {{-- <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <script src="{{ asset('admin/plugins/moment/moment.js')}}"></script>
  <script src='{{ asset('admin/plugins/fullcalendar/js/fullcalendar.min.js')}}'></script>
  <script src="{{ asset('admin/pages/calendar-init.js')}}"></script> --}}

  <script src="{{ asset('admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"></script>
  <script src="{{ asset('admin/pages/form-advanced.js') }}"></script>
  <script src="{{ asset('admin/plugins/chart.js/chart.min.js') }}"></script>
  <script src="{{ asset('admin/pages/chartjs.init.js') }}"></script>
  <script src="{{ asset('admin/plugins/raphael/raphael-min.js')}}"></script>
        <script src="{{ asset('admin/pages/dashboard.js')}}"></script>

  <script src="{{ asset('admin/js/app.js') }}"></script>

  <!-- Required datatable js -->
  <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <!-- Buttons examples -->
  <script src="{{ asset('admin/plugins/datatables/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/jszip.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/pdfmake.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/vfs_fonts.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/buttons.print.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/buttons.colVis.min.js') }}"></script>
  <!-- Responsive examples -->
  <script src="{{ asset('admin/plugins/datatables/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

  <!-- Datatable init js -->
  <script src="{{ asset('admin/pages/datatables.init.js') }}"></script>

  <!-- Parsley js -->
  <script src="{{ asset('admin/plugins/parsleyjs/parsley.min.js') }}"></script>

  <!--Morris Chart-->
  {{-- <script src="{{ asset('dashboard/plugins/morris/morris.min.js') }}"></script> --}}
  <script src="{{ asset('admin/plugins/raphael/raphael-min.js') }}"></script>
  <script src="{{ asset('dashboard/pages/dashboard.js') }}"></script>

  {{-- <script src="{{ asset('admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script> --}}

  <!-- Responsive-table-->
  <script src="{{ asset('admin/plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js') }}"></script>

  {{-- <script>
      $(function() {
          $('.table-responsive').responsiveTable({
              addDisplayAllBtn: 'btn btn-secondary'
          });
      });
  </script> --}}

  {{-- <!-- Pastikan jQuery telah dimuat terlebih dahulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Memuat Parsley.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.3/parsley.min.js"></script> --}}

  <script>
      $(document).ready(function() {
          $('form').parsley();
      });
  </script>

{{-- Image --}}
<script>
    $(document).ready(function() {
        // Memantau perubahan pada input file
        $('#image').on('change', function() {
            let fileInput = $(this);
            let file = fileInput.prop('files')[0];
            if (file) {
                let fileSize = file.size; // Ukuran file dalam bytes
                let maxSize = 2 * 1024 * 1024; // Maksimal 2MB

                // Validasi ukuran file
                if (fileSize > maxSize) {
                    $('#fileError').text('The foto field must not be greater than 2048 kilobytes.');
                    fileInput.addClass('is-invalid');
                    return;
                }

                // Validasi tipe file
                let fileType = file.type;
                let validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validImageTypes.includes(fileType)) {
                    $('#fileError').text('The foto field must be an image.');
                    fileInput.addClass('is-invalid');
                    return;
                }
            }

            // Hapus pesan kesalahan jika valid
            $('#fileError').text('');
            fileInput.removeClass('is-invalid');
        });

        // Validasi form sebelum submit
        $('form').submit(function(event) {
            let fileInput = $('#image');
            let file = fileInput.prop('files')[0];
            if (file) {
                let fileSize = file.size; // Ukuran file dalam bytes
                let maxSize = 2 * 1024 * 1024; // Maksimal 2MB

                // Validasi ukuran file
                if (fileSize > maxSize) {
                    $('#fileError').text('The foto field must not be greater than 2048 kilobytes.');
                    fileInput.addClass('is-invalid');
                    event.preventDefault(); // Menghentikan pengiriman form
                    return;
                }

                // Validasi tipe file
                let fileType = file.type;
                let validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validImageTypes.includes(fileType)) {
                    $('#fileError').text('The foto field must be an image.');
                    fileInput.addClass('is-invalid');
                    event.preventDefault(); // Menghentikan pengiriman form
                    return;
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Memantau perubahan pada input file
        $('#editimage').on('change', function() {
            let fileInput = $(this);
            let file = fileInput.prop('files')[0];
            if (file) {
                let fileSize = file.size; // Ukuran file dalam bytes
                let maxSize = 2 * 1024 * 1024; // Maksimal 2MB

                // Validasi ukuran file
                if (fileSize > maxSize) {
                    $('#fileErrorEdit').text('The foto field must not be greater than 2048 kilobytes.');
                    fileInput.addClass('is-invalid');
                    return;
                }

                // Validasi tipe file
                let fileType = file.type;
                let validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validImageTypes.includes(fileType)) {
                    $('#fileErrorEdit').text('The foto field must be an image.');
                    fileInput.addClass('is-invalid');
                    return;
                }
            }

            // Hapus pesan kesalahan jika valid
            $('#fileErrorEdit').text('');
            fileInput.removeClass('is-invalid');
        });

        // Validasi form sebelum submit
        $('form').submit(function(event) {
            let fileInput = $('#editimage');
            let file = fileInput.prop('files')[0];
            if (file) {
                let fileSize = file.size; // Ukuran file dalam bytes
                let maxSize = 2 * 1024 * 1024; // Maksimal 2MB

                // Validasi ukuran file
                if (fileSize > maxSize) {
                    $('#fileErrorEdit').text('The foto field must not be greater than 2048 kilobytes.');
                    fileInput.addClass('is-invalid');
                    event.preventDefault(); // Menghentikan pengiriman form
                    return;
                }

                // Validasi tipe file
                let fileType = file.type;
                let validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validImageTypes.includes(fileType)) {
                    $('#fileErrorEdit').text('The foto field must be an image.');
                    fileInput.addClass('is-invalid');
                    event.preventDefault(); // Menghentikan pengiriman form
                    return;
                }
            }
        });
    });
</script>

{{-- Periode --}}
<script>
    $(document).ready(function () {
        // Validasi tanggal untuk form tambah
        $('#tanggal_selesai, #batas_pendaftaran, #tgl_pengumuman').on('change', function () {
            validateDates('#tanggal_mulai', '#tanggal_selesai', '#batas_pendaftaran', '#tgl_pengumuman', '#error_tanggal_selesai', '#error_batas_pendaftaran', '#error_tgl_pengumuman', '#btnSubmit');
        });

        // Validasi tanggal untuk modal edit
        $('#editTanggalSelesai, #editBatasPendaftaran, #editTglPengumuman').on('change', function () {
            validateDates('#editTanggalMulai', '#editTanggalSelesai', '#editBatasPendaftaran', '#editTglPengumuman', '#error_tanggal_selesai_edit', '#error_batas_pendaftaran_edit', '#error_tgl_pengumuman_edit', '#btnEdit');
        });

        // Fungsi untuk validasi tanggal
        function validateDates(startDateSelector, endDateSelector, registrationDeadlineSelector, announcementDateSelector, errorEndDateSelector, errorRegistrationDeadlineSelector, errorAnnouncementDateSelector, submitButtonSelector) {
            var startDate = new Date($(startDateSelector).val());
            var endDate = new Date($(endDateSelector).val());
            var registrationDeadline = new Date($(registrationDeadlineSelector).val());
            var announcementDate = new Date($(announcementDateSelector).val());

            var isValidStartDate = true;
            var isValidRegistrationDeadline = true;
            var isValidAnnouncementDate = true;
            var isValidEndDate = true;

            // Cek batas pendaftaran
            if (registrationDeadline >= startDate) {
                $(errorRegistrationDeadlineSelector).text('Batas pendaftaran harus sebelum tanggal mulai.');
                isValidRegistrationDeadline = false;
            } else {
                $(errorRegistrationDeadlineSelector).text('');
            }

            // Cek tanggal pengumuman
            if (announcementDate <= registrationDeadline || announcementDate >= startDate) {
                $(errorAnnouncementDateSelector).text('Tanggal pengumuman harus setelah batas pendaftaran dan sebelum tanggal mulai.');
                isValidAnnouncementDate = false;
            } else {
                $(errorAnnouncementDateSelector).text('');
            }

            // Cek tanggal selesai
            if (endDate <= startDate) {
                $(errorEndDateSelector).text('Tanggal selesai harus setelah tanggal mulai.');
                isValidEndDate = false;
            } else {
                $(errorEndDateSelector).text('');
            }

            // Cek jika selisih tanggal mulai dan tanggal selesai minimal 1 bulan
            var oneMonthLater = new Date(startDate);
            oneMonthLater.setMonth(startDate.getMonth() + 1);

            if (endDate < oneMonthLater) {
                $(errorEndDateSelector).text('Tanggal selesai harus minimal 1 bulan setelah tanggal mulai.');
                isValidEndDate = false;
            } else {
                $(errorEndDateSelector).text('');
            }

            // Jika semua valid, aktifkan tombol submit
            if (isValidStartDate && isValidRegistrationDeadline && isValidAnnouncementDate && isValidEndDate) {
                $(submitButtonSelector).prop('disabled', false);
            } else {
                $(submitButtonSelector).prop('disabled', true);
            }
        }
    });
</script>




  <script>
      $(document).ready(function() {
        if ($("#feedback").length > 0) {
            tinymce.init({
                selector: "textarea#feedback",
                theme: "modern",
                height: 300,
                plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                }
            });
        }
      });
  </script>
  <script>
      $(document).ready(function() {
        if ($("#deskripsi").length > 0) {
            tinymce.init({
                selector: "textarea#deskripsi",
                theme: "modern",
                height: 300,
                plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                }
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
                plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                }
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
