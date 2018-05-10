    <script>
      "use strict";

      (function () {

        function onSuccess(responseText, boardElem, squareElem) {
          var responseData = JSON.parse(responseText);
        
          if (responseData.errors.length) {
            // TODO handle errors
          }
          else {
            switchSides(responseData.gameId, boardElem, squareElem);

            if (responseData.result) {
              endGame(boardElem);
            }
          }
        }

        function onFailure(repsonseText) {

        }

        function handleMove(squareElem) {
          var boardElem = squareElem.parentNode.parentNode.parentNode.parentNode;
          var gameId = boardElem.id.split("-")[2];
          var square = squareElem.id.split("-")[3];
          var moveRequest = ajax(
            "index.php?page=move",
            function (responseText) { onSuccess(responseText, boardElem, squareElem); }, 
            onFailure
          );
          moveRequest.send("game_id=" + gameId + "&square=" + square);
        }

        function endGame(boardElem) {
          
        }

        function switchSides(gameId, boardElem, squareElem) {
          var side = squareElem.className.indexOf("movable-x") >= 0 ? "X" : "O";
          boardElem.classList.remove("ttt-board-toplay");
          makeImmovable(boardElem);
          var toPlayElem = document.getElementById("ttt-toplay-" + gameId);
          toPlayElem.innerHTML = "to play: " + (toPlayElem.innerHTML.indexOf("X") >= 0 ? "O" : "X");
          squareElem.innerHTML = side;
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
