<script type="text/javascript">
    var maxField = 5;
    var x = 1;

    $(document).ready(function() {
      $(".btn-success").click(function(){
          if(x < maxField){
              var html = $(".clone").html();
              $(".increment").after(html);
              x++;
          }
      });
      $("body").on("click",".btn-danger",function(){
          $(this).parents(".control-group").remove();
          x--;
      });
    });
</script>
