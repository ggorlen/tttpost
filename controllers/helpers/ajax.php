<?php

function getAjax() {
    return <<<JS
    <script>
      "use strict";

      function ajax(url, onSuccess, onFailure, requestType, contentType) {
        var request = new XMLHttpRequest();

        request.onreadystatechange = function () {
          if (request.readyState === 4) {
            if (request.status === 200) {
              onSuccess(request.responseText);
            }
            else {
              onFailure(request.responseText);
            }
          }
        };

        request.open(requestType ? requestType : "post", url);
        request.setRequestHeader(
          "Content-type",
          contentType ? contentType : "application/x-www-form-urlencoded"
        );
        return request;
      }
    </script>

JS;
} // end getAjax

?>
