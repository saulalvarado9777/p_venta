<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="../js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../js/demo.js"></script>
<!-- sweetalert2 -->
<script src="../js/sweetalert2.js"></script>
<!-- select2 -->
<script src="../js/select2.js"></script>
<script src="../js/datatables.js"></script>

</body>
<script>
  funcion='tipo_usuario';
  $.post('../controlador/usuario_controller.php',{funcion},(response)=>
  {
      //console.log(Response);
      if(response==2)
      {
        $('#usuarios_h').hide();
        $('#datos_personales').hide();
        $('#usuario').hide();
        $('#almacen_h').hide();
        $('#prod').hide();
        $('#sto').hide();
        $('#cat').hide();
        $('#comprar_h').hide();
        $('#prov').hide();
      }

  })
</script>
</html>