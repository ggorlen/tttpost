<div class="ttt-new-seek">
  <a id="ttt-new-seek-btn" href="#">new seek</a>
</div>

<script>

(function () {
  "use strict";

  var newSeek = document.getElementById('ttt-new-seek-btn');
  var request = new XMLHttpRequest();
  var url = '<?= 'index.php?page=newseek' ?>';
   
  request.onreadystatechange = function () {
    if (request.readyState === 4) {
      if (request.status === 200) { 
        console.log(request.responseText);
        // success
  
        request.open('post', url);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      } 
      else {
        // TODO set limit on number of seeks
        // fail
      } 
    }
  };
   
  request.open('post', url);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
  newSeek.addEventListener('click', function () {
    request.send();
  });
})();  

</script>
