$(document).ready(function() {
    // Filter Papers
    $(document).find("#stage_id").prepend("<option value='' selected='selected'>All Level</option>");
    $(document).find("#exam_type_id").prepend("<option value='' selected='selected'>All Exam Type</option>");
    $(document).find("#subject_id").prepend("<option value='' selected='selected'>All Subject</option>");

    $(document).find('.filter').on('change',function() {
      var type=$('.filter :selected').parent().attr('data-group');
      var examTypeId = $(document).find('#exam_type_id').val();
      var categoryId = $(this).attr('data-category-id');
      var subjectId = $(document).find('#subject_id').val();
      var stageId = $(document).find('#stage_id').val();
      $.ajax({
          url: $(this).attr('data-url'),
          method: "POST",
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          global: false,
          data: { exam_type_id: examTypeId, category_id : categoryId, subject_id : subjectId, type : type, stage_id:stageId },
          success: function (result) {
            $(document).find('.paper-lst-filter').html(result.paperData);
            
            $(function() {
              $(document).find('.fixedStar').raty({
                readOnly:  true,
                path    :  base_url+'/public/frontend/images',
                starOff : 'star-off.svg',
                starOn  : 'star-on.svg',
                start: $(document).find(this).attr('data-score')
              });
            });
          }
      });
    });    
});