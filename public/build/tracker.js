(self["webpackChunk"] = self["webpackChunk"] || []).push([["tracker"],{

/***/ "./assets/tracker.js":
/*!***************************!*\
  !*** ./assets/tracker.js ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.array.concat.js */ "./node_modules/core-js/modules/es.array.concat.js");
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _styles_tracker_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./styles/tracker.css */ "./assets/styles/tracker.css");




document.getElementById('tracker__btn').addEventListener('click', function (event) {
  event.preventDefault();
  var button = event.target;
  var code = document.getElementById('tracker_code');

  if (code.value && /^SR-[0-9]{10}$/.test(code.value)) {
    button.disabled = true;
    button.classList.add('disabled');
    code.disabled = true;
    fetch('/tracker', {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: code.value
    }).then(function (response) {
      if (response.ok) {
        return response.json();
      }

      throw Error(response.statusText);
    }).then(function (data) {
      code.value = '';
      button.disabled = false;
      button.classList.remove('disabled');
      code.disabled = false;
      showResults(data);
    })["catch"](function (error) {
      code.value = '';
      button.disabled = false;
      button.classList.remove('disabled');
      code.disabled = false;
      showResults(error);
    });
  }
});

function showResults(data) {
  var content = document.getElementById('content__block');
  content.style.display = 'initial';

  if (!data.hasOwnProperty('code')) {
    content.innerHTML = "<div id=\"msg\">".concat(data, "</div>");
    return null;
  }

  content.innerHTML = "\n        <div>Code: <span id=\"code\">".concat(data.code, "</span></div>\n        <div>Status: <span id=\"status\">").concat(data.status, "</span></div>\n        <div>Category: <span id=\"category\">").concat(data.category, "</span></div>\n        <div style=\"display: ").concat(data.colour === null ? "none" : "initial", "\">Colour: <span id='colour' title=\"").concat(data.colour, "\"></span></div>\n        <div>Fault: <span id=\"fault\">").concat(data.fault, "</span></div>\n        <div style=\"display: ").concat(data.publicComment === null ? "none" : "initial", "\">Comment: <span id=\"publicComment\">").concat(data.publicComment, "</span></div>\n        <div>Created: <span id=\"created\">").concat(data.created, "</span></div>\n    ");
  document.getElementById('colour').style.backgroundColor = data.colour;
  document.getElementById('status').style.backgroundColor = data.status_color;
}

/***/ }),

/***/ "./assets/styles/tracker.css":
/*!***********************************!*\
  !*** ./assets/styles/tracker.css ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ "use strict";
/******/ 
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_array_concat_js-node_modules_core-js_modules_es_objec-cc1af2"], () => (__webpack_exec__("./assets/tracker.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvdHJhY2tlci5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3R5bGVzL3RyYWNrZXIuY3NzPzIxZWEiXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJnZXRFbGVtZW50QnlJZCIsImFkZEV2ZW50TGlzdGVuZXIiLCJldmVudCIsInByZXZlbnREZWZhdWx0IiwiYnV0dG9uIiwidGFyZ2V0IiwiY29kZSIsInZhbHVlIiwidGVzdCIsImRpc2FibGVkIiwiY2xhc3NMaXN0IiwiYWRkIiwiZmV0Y2giLCJtZXRob2QiLCJoZWFkZXJzIiwiYm9keSIsInRoZW4iLCJyZXNwb25zZSIsIm9rIiwianNvbiIsIkVycm9yIiwic3RhdHVzVGV4dCIsImRhdGEiLCJyZW1vdmUiLCJzaG93UmVzdWx0cyIsImVycm9yIiwiY29udGVudCIsInN0eWxlIiwiZGlzcGxheSIsImhhc093blByb3BlcnR5IiwiaW5uZXJIVE1MIiwic3RhdHVzIiwiY2F0ZWdvcnkiLCJjb2xvdXIiLCJmYXVsdCIsInB1YmxpY0NvbW1lbnQiLCJjcmVhdGVkIiwiYmFja2dyb3VuZENvbG9yIiwic3RhdHVzX2NvbG9yIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQUFBO0FBRUFBLFFBQVEsQ0FBQ0MsY0FBVCxDQUF3QixjQUF4QixFQUF3Q0MsZ0JBQXhDLENBQXlELE9BQXpELEVBQWtFLFVBQUNDLEtBQUQsRUFBVztBQUN6RUEsT0FBSyxDQUFDQyxjQUFOO0FBRUEsTUFBTUMsTUFBTSxHQUFHRixLQUFLLENBQUNHLE1BQXJCO0FBQ0EsTUFBTUMsSUFBSSxHQUFHUCxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsY0FBeEIsQ0FBYjs7QUFFQSxNQUFHTSxJQUFJLENBQUNDLEtBQUwsSUFBZSxpQkFBaUJDLElBQWpCLENBQXNCRixJQUFJLENBQUNDLEtBQTNCLENBQWxCLEVBQXNEO0FBQ2xESCxVQUFNLENBQUNLLFFBQVAsR0FBa0IsSUFBbEI7QUFDQUwsVUFBTSxDQUFDTSxTQUFQLENBQWlCQyxHQUFqQixDQUFxQixVQUFyQjtBQUNBTCxRQUFJLENBQUNHLFFBQUwsR0FBZ0IsSUFBaEI7QUFDQUcsU0FBSyxDQUFDLFVBQUQsRUFBYTtBQUNkQyxZQUFNLEVBQUUsTUFETTtBQUVkQyxhQUFPLEVBQUU7QUFDTCw0QkFBb0I7QUFEZixPQUZLO0FBS2RDLFVBQUksRUFBRVQsSUFBSSxDQUFDQztBQUxHLEtBQWIsQ0FBTCxDQU1HUyxJQU5ILENBTVEsVUFBQ0MsUUFBRCxFQUFjO0FBQ2xCLFVBQUdBLFFBQVEsQ0FBQ0MsRUFBWixFQUFlO0FBQ1gsZUFBT0QsUUFBUSxDQUFDRSxJQUFULEVBQVA7QUFDSDs7QUFDRCxZQUFNQyxLQUFLLENBQUNILFFBQVEsQ0FBQ0ksVUFBVixDQUFYO0FBQ0gsS0FYRCxFQVdHTCxJQVhILENBV1EsVUFBQ00sSUFBRCxFQUFVO0FBQ2RoQixVQUFJLENBQUNDLEtBQUwsR0FBYSxFQUFiO0FBQ0FILFlBQU0sQ0FBQ0ssUUFBUCxHQUFrQixLQUFsQjtBQUNBTCxZQUFNLENBQUNNLFNBQVAsQ0FBaUJhLE1BQWpCLENBQXdCLFVBQXhCO0FBQ0FqQixVQUFJLENBQUNHLFFBQUwsR0FBZ0IsS0FBaEI7QUFDQWUsaUJBQVcsQ0FBQ0YsSUFBRCxDQUFYO0FBQ0gsS0FqQkQsV0FpQlMsVUFBQ0csS0FBRCxFQUFXO0FBQ2hCbkIsVUFBSSxDQUFDQyxLQUFMLEdBQWEsRUFBYjtBQUNBSCxZQUFNLENBQUNLLFFBQVAsR0FBa0IsS0FBbEI7QUFDQUwsWUFBTSxDQUFDTSxTQUFQLENBQWlCYSxNQUFqQixDQUF3QixVQUF4QjtBQUNBakIsVUFBSSxDQUFDRyxRQUFMLEdBQWdCLEtBQWhCO0FBQ0FlLGlCQUFXLENBQUNDLEtBQUQsQ0FBWDtBQUNILEtBdkJEO0FBd0JIO0FBQ0osQ0FuQ0Q7O0FBcUNBLFNBQVNELFdBQVQsQ0FBcUJGLElBQXJCLEVBQTJCO0FBQ3ZCLE1BQU1JLE9BQU8sR0FBRzNCLFFBQVEsQ0FBQ0MsY0FBVCxDQUF3QixnQkFBeEIsQ0FBaEI7QUFDQTBCLFNBQU8sQ0FBQ0MsS0FBUixDQUFjQyxPQUFkLEdBQXdCLFNBQXhCOztBQUVBLE1BQUcsQ0FBQ04sSUFBSSxDQUFDTyxjQUFMLENBQW9CLE1BQXBCLENBQUosRUFBaUM7QUFDN0JILFdBQU8sQ0FBQ0ksU0FBUiw2QkFBcUNSLElBQXJDO0FBQ0EsV0FBTyxJQUFQO0FBQ0g7O0FBRURJLFNBQU8sQ0FBQ0ksU0FBUixvREFDaUNSLElBQUksQ0FBQ2hCLElBRHRDLHFFQUVxQ2dCLElBQUksQ0FBQ1MsTUFGMUMseUVBR3lDVCxJQUFJLENBQUNVLFFBSDlDLDBEQUkyQlYsSUFBSSxDQUFDVyxNQUFMLEtBQWdCLElBQWhCLEdBQXVCLE1BQXZCLEdBQWdDLFNBSjNELGtEQUkwR1gsSUFBSSxDQUFDVyxNQUovRyxzRUFLbUNYLElBQUksQ0FBQ1ksS0FMeEMsMERBTTJCWixJQUFJLENBQUNhLGFBQUwsS0FBdUIsSUFBdkIsR0FBOEIsTUFBOUIsR0FBdUMsU0FObEUsb0RBTWtIYixJQUFJLENBQUNhLGFBTnZILHVFQU91Q2IsSUFBSSxDQUFDYyxPQVA1QztBQVVBckMsVUFBUSxDQUFDQyxjQUFULENBQXdCLFFBQXhCLEVBQWtDMkIsS0FBbEMsQ0FBd0NVLGVBQXhDLEdBQTBEZixJQUFJLENBQUNXLE1BQS9EO0FBQ0FsQyxVQUFRLENBQUNDLGNBQVQsQ0FBd0IsUUFBeEIsRUFBa0MyQixLQUFsQyxDQUF3Q1UsZUFBeEMsR0FBMERmLElBQUksQ0FBQ2dCLFlBQS9EO0FBQ0gsQzs7Ozs7Ozs7Ozs7O0FDNUREIiwiZmlsZSI6InRyYWNrZXIuanMiLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgJy4vc3R5bGVzL3RyYWNrZXIuY3NzJztcclxuXHJcbmRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd0cmFja2VyX19idG4nKS5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChldmVudCkgPT4ge1xyXG4gICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcclxuXHJcbiAgICBjb25zdCBidXR0b24gPSBldmVudC50YXJnZXQ7XHJcbiAgICBjb25zdCBjb2RlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3RyYWNrZXJfY29kZScpO1xyXG5cclxuICAgIGlmKGNvZGUudmFsdWUgJiYgKC9eU1ItWzAtOV17MTB9JC8udGVzdChjb2RlLnZhbHVlKSkpIHtcclxuICAgICAgICBidXR0b24uZGlzYWJsZWQgPSB0cnVlO1xyXG4gICAgICAgIGJ1dHRvbi5jbGFzc0xpc3QuYWRkKCdkaXNhYmxlZCcpO1xyXG4gICAgICAgIGNvZGUuZGlzYWJsZWQgPSB0cnVlO1xyXG4gICAgICAgIGZldGNoKCcvdHJhY2tlcicsIHtcclxuICAgICAgICAgICAgbWV0aG9kOiAnUE9TVCcsXHJcbiAgICAgICAgICAgIGhlYWRlcnM6IHtcclxuICAgICAgICAgICAgICAgICdYLVJlcXVlc3RlZC1XaXRoJzogJ1hNTEh0dHBSZXF1ZXN0J1xyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICBib2R5OiBjb2RlLnZhbHVlXHJcbiAgICAgICAgfSkudGhlbigocmVzcG9uc2UpID0+IHtcclxuICAgICAgICAgICAgaWYocmVzcG9uc2Uub2spe1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuIHJlc3BvbnNlLmpzb24oKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB0aHJvdyBFcnJvcihyZXNwb25zZS5zdGF0dXNUZXh0KTtcclxuICAgICAgICB9KS50aGVuKChkYXRhKSA9PiB7XHJcbiAgICAgICAgICAgIGNvZGUudmFsdWUgPSAnJztcclxuICAgICAgICAgICAgYnV0dG9uLmRpc2FibGVkID0gZmFsc2U7XHJcbiAgICAgICAgICAgIGJ1dHRvbi5jbGFzc0xpc3QucmVtb3ZlKCdkaXNhYmxlZCcpO1xyXG4gICAgICAgICAgICBjb2RlLmRpc2FibGVkID0gZmFsc2U7XHJcbiAgICAgICAgICAgIHNob3dSZXN1bHRzKGRhdGEpO1xyXG4gICAgICAgIH0pLmNhdGNoKChlcnJvcikgPT4ge1xyXG4gICAgICAgICAgICBjb2RlLnZhbHVlID0gJyc7XHJcbiAgICAgICAgICAgIGJ1dHRvbi5kaXNhYmxlZCA9IGZhbHNlO1xyXG4gICAgICAgICAgICBidXR0b24uY2xhc3NMaXN0LnJlbW92ZSgnZGlzYWJsZWQnKTtcclxuICAgICAgICAgICAgY29kZS5kaXNhYmxlZCA9IGZhbHNlO1xyXG4gICAgICAgICAgICBzaG93UmVzdWx0cyhlcnJvcik7XHJcbiAgICAgICAgfSk7XHJcbiAgICB9XHJcbn0pO1xyXG5cclxuZnVuY3Rpb24gc2hvd1Jlc3VsdHMoZGF0YSkge1xyXG4gICAgY29uc3QgY29udGVudCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdjb250ZW50X19ibG9jaycpO1xyXG4gICAgY29udGVudC5zdHlsZS5kaXNwbGF5ID0gJ2luaXRpYWwnO1xyXG5cclxuICAgIGlmKCFkYXRhLmhhc093blByb3BlcnR5KCdjb2RlJykpIHtcclxuICAgICAgICBjb250ZW50LmlubmVySFRNTCA9IGA8ZGl2IGlkPVwibXNnXCI+JHtkYXRhfTwvZGl2PmA7XHJcbiAgICAgICAgcmV0dXJuIG51bGw7XHJcbiAgICB9XHJcblxyXG4gICAgY29udGVudC5pbm5lckhUTUwgPSBgXHJcbiAgICAgICAgPGRpdj5Db2RlOiA8c3BhbiBpZD1cImNvZGVcIj4ke2RhdGEuY29kZX08L3NwYW4+PC9kaXY+XHJcbiAgICAgICAgPGRpdj5TdGF0dXM6IDxzcGFuIGlkPVwic3RhdHVzXCI+JHtkYXRhLnN0YXR1c308L3NwYW4+PC9kaXY+XHJcbiAgICAgICAgPGRpdj5DYXRlZ29yeTogPHNwYW4gaWQ9XCJjYXRlZ29yeVwiPiR7ZGF0YS5jYXRlZ29yeX08L3NwYW4+PC9kaXY+XHJcbiAgICAgICAgPGRpdiBzdHlsZT1cImRpc3BsYXk6ICR7ZGF0YS5jb2xvdXIgPT09IG51bGwgPyBcIm5vbmVcIiA6IFwiaW5pdGlhbFwifVwiPkNvbG91cjogPHNwYW4gaWQ9J2NvbG91cicgdGl0bGU9XCIke2RhdGEuY29sb3VyfVwiPjwvc3Bhbj48L2Rpdj5cclxuICAgICAgICA8ZGl2PkZhdWx0OiA8c3BhbiBpZD1cImZhdWx0XCI+JHtkYXRhLmZhdWx0fTwvc3Bhbj48L2Rpdj5cclxuICAgICAgICA8ZGl2IHN0eWxlPVwiZGlzcGxheTogJHtkYXRhLnB1YmxpY0NvbW1lbnQgPT09IG51bGwgPyBcIm5vbmVcIiA6IFwiaW5pdGlhbFwifVwiPkNvbW1lbnQ6IDxzcGFuIGlkPVwicHVibGljQ29tbWVudFwiPiR7ZGF0YS5wdWJsaWNDb21tZW50fTwvc3Bhbj48L2Rpdj5cclxuICAgICAgICA8ZGl2PkNyZWF0ZWQ6IDxzcGFuIGlkPVwiY3JlYXRlZFwiPiR7ZGF0YS5jcmVhdGVkfTwvc3Bhbj48L2Rpdj5cclxuICAgIGA7XHJcblxyXG4gICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2NvbG91cicpLnN0eWxlLmJhY2tncm91bmRDb2xvciA9IGRhdGEuY29sb3VyO1xyXG4gICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3N0YXR1cycpLnN0eWxlLmJhY2tncm91bmRDb2xvciA9IGRhdGEuc3RhdHVzX2NvbG9yO1xyXG59IiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307Il0sInNvdXJjZVJvb3QiOiIifQ==