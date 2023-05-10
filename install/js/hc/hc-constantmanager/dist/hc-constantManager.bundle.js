this.hc = this.hc || {};
(function (exports,main_core) {
	'use strict';

	var HcConstantManager = /*#__PURE__*/function () {
	  function HcConstantManager() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
	      name: 'HcConstantManager'
	    };
	    babelHelpers.classCallCheck(this, HcConstantManager);
	    this.name = options.name;
	  }
	  babelHelpers.createClass(HcConstantManager, null, [{
	    key: "getPostConstants",
	    value: function getPostConstants() {
	      return new Promise(function (resolve, reject) {
	        BX.ajax.runAction('hc:houseceeper.PostType.getTypes').then(function (responce) {
	          resolve(responce);
	        })["catch"](function (error) {
	          console.log(error);
	          reject(error);
	        });
	      });
	    }
	  }, {
	    key: "getPostConstantsRu",
	    value: function getPostConstantsRu() {
	      return new Promise(function (resolve, reject) {
	        BX.ajax.runAction('hc:houseceeper.PostType.getTypesRuLang').then(function (responce) {
	          resolve(responce);
	        })["catch"](function (error) {
	          console.log(error);
	          reject(error);
	        });
	      });
	    }
	  }]);
	  return HcConstantManager;
	}();

	exports.HcConstantManager = HcConstantManager;

}((this.hc.houseceeper = this.hc.houseceeper || {}),BX));
