<?php

echo <<<JS
    <script>
      "use strict";

      (function () {
        function handleNewSeek(responseText) {

          // TODO just prepare the one new node
          var html = responseText.split("\\n");
          seeksContainer.innerHTML = html.slice(1, html.length - 1).join("\\n");
          prepareSeekNodes();
        }

        function handleNewSeekFailure(responseText) {

          // TODO
          console.log(responseText);
        }

        function prepareSeekNode(node) {
          node.addEventListener("click", function (e) {
            var self = this;
            var id = e.target.parentNode.parentNode.id.split("-");
            id = id[id.length-1];
            
            if (e.target.innerText.indexOf("remove") >= 0) { // TODO brittle
              var removeSeekRequest = ajax(
                'index.php?page=removeseek', 
                function (responseText) { 
                  self.parentNode.removeChild(self);
                },
                function (responseText) { 
                  // TODO show error
                  console.log(responseText);
                }
              );
              removeSeekRequest.send("id=" + id);
            }
            else if (e.target.innerText.indexOf("join") >= 0) { // TODO brittle
              var joinSeekRequest = ajax(
                'index.php?page=joinseek', 
                function (responseText) { 
                  self.parentNode.removeChild(self);
                },
                function (responseText) { 
                  // TODO show error
                  console.log(responseText);
                }
              );
              joinSeekRequest.send("id=" + id);
            }
          });
        
        }

        function prepareSeekNodes() {  
          var seeks = document.getElementsByClassName("ttt-seek");
        
          for (var i = 0; i < seeks.length; i++) {
            prepareSeekNode(seeks[i]);
          }
        }

        var newSeek = document.getElementById("ttt-new-seek-btn");
        var seeksContainer = document.getElementById("ttt-seeks-container");

        newSeek.addEventListener("click", function () {
          var newSeekRequest = ajax(
            'index.php?page=newseek', 
            handleNewSeek, 
            handleNewSeekFailure
          );
          newSeekRequest.send();
          newSeekRequest = ajax(
            'index.php?page=newseek', 
            handleNewSeek, 
            handleNewSeekFailure
          );
        });

        prepareSeekNodes();
      })();

    </script>
JS

?>
