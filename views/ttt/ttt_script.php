    <script>
      "use strict";

      (function () {
        function handleMove(self) {
          var gameElem = self.parentNode.parentNode.parentNode.parentNode;
          var gameId = gameElem.id.split("-")[2];
          var square = self.id.split("-")[2];

          var moveRequest = ajax(
            'index.php?page=move',
            function (responseText) {
              if (responseText) {
                var side = self.className.indexOf("movable-x") >= 0 ? "X" : "O";
                deactivateBoard(gameElem, gameId);
                self.innerHTML = side;
              }
            },
            function (responseText) {
              // TODO show error
              console.log(responseText);
            }
          );
          moveRequest.send("game_id=" + gameId + "&square=" + square);
          moveRequest = ajax(
            'index.php?page=move',
            function (responseText) {
              if (responseText) {
                var side = self.className.indexOf("movable-x") >= 0 ? "X" : "O";
                deactivateBoard(gameElem, gameId);
                self.innerHTML = side;
              }
            },
            function (responseText) {
              // TODO show error
              console.log(responseText);
            }
          );
        }

        function deactivateBoard(boardElem, gameId) {
          boardElem.classList.remove("ttt-board-toplay");
          makeImmovable(boardElem);
          var toPlayElem = document.getElementById("ttt-toplay-" + gameId);
          toPlayElem.innerHTML = "to play: " + (toPlayElem.innerHTML.indexOf("X") >= 0 ? "O" : "X");
        }

        function makeImmovable(elem) {
          if (elem.children.length) {
            for (var i = 0; i < elem.children.length; i++) {
              makeImmovable(elem.children[i]);
            }
          }
          else {
            elem.classList.remove("movable");
            elem.classList.remove("movable-x");
            elem.classList.remove("movable-o");
          }
        }

        var movableSquares = document.getElementsByClassName("movable");

        for (var i = 0; i < movableSquares.length; i++) {
          movableSquares[i].addEventListener("mouseover", function (e) {
            if (e.target.className.indexOf("movable") >= 0) {
              e.target.innerHTML = e.target.className.indexOf("movable-x") >= 0 ? "X" : "O";
            }
          });

          movableSquares[i].addEventListener("mouseout", function (e) {
            if (e.target.className.indexOf("movable") >= 0) {
              e.target.innerHTML = "";
            }
          });

          movableSquares[i].addEventListener("click", function (e) {
            if (e.target.className.indexOf("movable") >= 0) {
              handleMove(this);
            }
          });
        }  
      })();

    </script>
