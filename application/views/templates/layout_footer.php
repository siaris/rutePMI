</body>
</html>

<script src="<?php echo base_url('assets/js/bootstrap-typeahead.js');?>"></script>
<script>
/*
 $('#general_search').typeahead({
               source: function(typeahead, query) {
               $.ajax({
                  url: "<?php echo site_url('master/pasien/typeahead')?>",
                  dataType: "json",
                  type: "POST",
                  data: {
                      max_rows: 15,
                      q: query,
                  },
                  success: function(data) {
                      var return_list = [], i = data.length;
                      while (i--) {
                          return_list[i] = {id: data[i].id, value: data[i].no_rm + ' - ' + data[i].nama, no_rm: data[i].no_rm,nama: data[i].nama,tanggal_lahir: data[i].tanggal_lahir};
                      }
                      typeahead.process(return_list);
                  }
               });
            },
            onselect: function(obj) {
              $('#no_rms').val(obj.no_rm);
			  $('[name="general_search"]').val(obj.nama);
            },
            items: 15
         });
*/		 
$('#no_rms').typeahead({
               source: function(typeahead, query) {
               $.ajax({
                  url: "<?php echo site_url('master/pasien/typeahead')?>",
                  dataType: "json",
                  type: "POST",
                  data: {
                      max_rows: 15,
                      q: query,
                  },
                  success: function(data) {
                      var return_list = [], i = data.length;
                      while (i--) {
                          return_list[i] = {id: data[i].id, value: data[i].no_rm + ' - ' + data[i].nama, no_rm: data[i].no_rm,nama: data[i].nama,tanggal_lahir: data[i].tanggal_lahir};
                      }
                      typeahead.process(return_list);
                  }
               });
            },
            onselect: function(obj) {
              $('#no_rms').val(obj.no_rm);
			  window.location.href = "<?php echo site_url('pasien/cari'); ?>/"+obj.no_rm;  // cek di routes.php
			  //$('[name="general_search"]').val(obj.nama);
            },
            items: 15
         });
</script>
<script type="text/javascript">
		$(document).ready(function(){
		$('#menu ul').sliding_menu_js({
		//header_title:'jQueryScript.Net!', // the title of the header
		//header_logo: "logo.png", // logo image
		toggle_button: true, // show the toggle button
		transitionSpeed: 0.5, // the animation speed of transition
		easing: 'ease' // easing effects
		});
		});
</script>
<script>
    $('#popup_search').bind(hitEvent, function() {
      $.ajax({
         url: "<?php echo site_url('search/search_simrs')?>",
         type: "GET",
         dataType: "json",
         data: {"format":"json"},
         context: document.body,
         success: function(data) { alert(data);
            
            var dom = $(data.html);
            var box = bootbox.modal(dom, 'Pencarian Pasien', {"backdrop":"static"});
            dom.filter('script').each(function(){
                $.globalEval(this.text || this.textContent || this.innerHTML || '');
            });
            $(box).css({
               'width':'100%',
               'margin-left':'',
			   
            });
            
            $(box).find('.form-actions').hide();
            $(box).find('form').removeClass('well');
            var button = $(box).find('.form-actions .save-btn');
            var buttonClose = '<a class="btn close-btn" href="javascript:;">Tutup</a>';
            $(box).append('<div class="modal-footer"></div>');
            $(box).find('.modal-footer').html(button).append(buttonClose);
            $(box).find('.save-btn').bind(hitEvent, function() {
               $(box).find('form').submit();
               //$(box).find('.form-actions').hide();
            });
            
         }
      });
   });
</script>