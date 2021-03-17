<!doctype html>
<html lang="">
    <head>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "b27ac1bf-f719-4b8b-a2c8-b8e01131a2df",
    });
  });
</script>
    </head>
    <body>




            <form method="post" enctype="multipart/form-data" id="upload-file" action="http://127.0.0.1:8080/api/user/setting">
                 
                 <div class="row">
        
                     <div class="col-md-12">
                         <div class="form-group">
                             <input type="text" name="name">
                             <input type="file" name="file">
                         </div>
                     </div>
                     <div class="col-md-12">
                         <div class="form-group">
                             <input type="hidden" name="user_id" value="783941393">
                         </div>
                     </div>
                        
                     <div class="col-md-12">
                         <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                     </div>
                 </div>     
             </form>
   


    </body>
</html>
