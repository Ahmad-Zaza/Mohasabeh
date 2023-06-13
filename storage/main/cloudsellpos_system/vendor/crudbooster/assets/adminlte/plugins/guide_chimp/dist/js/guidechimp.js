/*! GuideChimp v4.2.2 | Copyright (C) 2022 Labs64 GmbH */
(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["GuideChimp"] = factory();
	else
		root["GuideChimp"] = factory();
})(self, function() {
return /******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ 7228:
/***/ (function(module) {

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

module.exports = _arrayLikeToArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 2858:
/***/ (function(module) {

function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

module.exports = _arrayWithHoles, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 3646:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var arrayLikeToArray = __webpack_require__(7228);

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return arrayLikeToArray(arr);
}

module.exports = _arrayWithoutHoles, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 8926:
/***/ (function(module) {

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
  try {
    var info = gen[key](arg);
    var value = info.value;
  } catch (error) {
    reject(error);
    return;
  }

  if (info.done) {
    resolve(value);
  } else {
    Promise.resolve(value).then(_next, _throw);
  }
}

function _asyncToGenerator(fn) {
  return function () {
    var self = this,
        args = arguments;
    return new Promise(function (resolve, reject) {
      var gen = fn.apply(self, args);

      function _next(value) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
      }

      function _throw(err) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
      }

      _next(undefined);
    });
  };
}

module.exports = _asyncToGenerator, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 4575:
/***/ (function(module) {

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

module.exports = _classCallCheck, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 9100:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var setPrototypeOf = __webpack_require__(9489);

var isNativeReflectConstruct = __webpack_require__(7067);

function _construct(Parent, args, Class) {
  if (isNativeReflectConstruct()) {
    module.exports = _construct = Reflect.construct, module.exports.__esModule = true, module.exports["default"] = module.exports;
  } else {
    module.exports = _construct = function _construct(Parent, args, Class) {
      var a = [null];
      a.push.apply(a, args);
      var Constructor = Function.bind.apply(Parent, a);
      var instance = new Constructor();
      if (Class) setPrototypeOf(instance, Class.prototype);
      return instance;
    }, module.exports.__esModule = true, module.exports["default"] = module.exports;
  }

  return _construct.apply(null, arguments);
}

module.exports = _construct, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 3913:
/***/ (function(module) {

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  Object.defineProperty(Constructor, "prototype", {
    writable: false
  });
  return Constructor;
}

module.exports = _createClass, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 9713:
/***/ (function(module) {

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 5318:
/***/ (function(module) {

function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {
    "default": obj
  };
}

module.exports = _interopRequireDefault, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 7067:
/***/ (function(module) {

function _isNativeReflectConstruct() {
  if (typeof Reflect === "undefined" || !Reflect.construct) return false;
  if (Reflect.construct.sham) return false;
  if (typeof Proxy === "function") return true;

  try {
    Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {}));
    return true;
  } catch (e) {
    return false;
  }
}

module.exports = _isNativeReflectConstruct, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 6860:
/***/ (function(module) {

function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
}

module.exports = _iterableToArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 3884:
/***/ (function(module) {

function _iterableToArrayLimit(arr, i) {
  var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"];

  if (_i == null) return;
  var _arr = [];
  var _n = true;
  var _d = false;

  var _s, _e;

  try {
    for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

module.exports = _iterableToArrayLimit, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 521:
/***/ (function(module) {

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

module.exports = _nonIterableRest, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 8206:
/***/ (function(module) {

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

module.exports = _nonIterableSpread, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 9591:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var _typeof = (__webpack_require__(8)["default"]);

function _regeneratorRuntime() {
  "use strict";
  /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */

  module.exports = _regeneratorRuntime = function _regeneratorRuntime() {
    return exports;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports;
  var exports = {},
      Op = Object.prototype,
      hasOwn = Op.hasOwnProperty,
      $Symbol = "function" == typeof Symbol ? Symbol : {},
      iteratorSymbol = $Symbol.iterator || "@@iterator",
      asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator",
      toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    return Object.defineProperty(obj, key, {
      value: value,
      enumerable: !0,
      configurable: !0,
      writable: !0
    }), obj[key];
  }

  try {
    define({}, "");
  } catch (err) {
    define = function define(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator,
        generator = Object.create(protoGenerator.prototype),
        context = new Context(tryLocsList || []);
    return generator._invoke = function (innerFn, self, context) {
      var state = "suspendedStart";
      return function (method, arg) {
        if ("executing" === state) throw new Error("Generator is already running");

        if ("completed" === state) {
          if ("throw" === method) throw arg;
          return doneResult();
        }

        for (context.method = method, context.arg = arg;;) {
          var delegate = context.delegate;

          if (delegate) {
            var delegateResult = maybeInvokeDelegate(delegate, context);

            if (delegateResult) {
              if (delegateResult === ContinueSentinel) continue;
              return delegateResult;
            }
          }

          if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) {
            if ("suspendedStart" === state) throw state = "completed", context.arg;
            context.dispatchException(context.arg);
          } else "return" === context.method && context.abrupt("return", context.arg);
          state = "executing";
          var record = tryCatch(innerFn, self, context);

          if ("normal" === record.type) {
            if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue;
            return {
              value: record.arg,
              done: context.done
            };
          }

          "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg);
        }
      };
    }(innerFn, self, context), generator;
  }

  function tryCatch(fn, obj, arg) {
    try {
      return {
        type: "normal",
        arg: fn.call(obj, arg)
      };
    } catch (err) {
      return {
        type: "throw",
        arg: err
      };
    }
  }

  exports.wrap = wrap;
  var ContinueSentinel = {};

  function Generator() {}

  function GeneratorFunction() {}

  function GeneratorFunctionPrototype() {}

  var IteratorPrototype = {};
  define(IteratorPrototype, iteratorSymbol, function () {
    return this;
  });
  var getProto = Object.getPrototypeOf,
      NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype);
  var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype);

  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function (method) {
      define(prototype, method, function (arg) {
        return this._invoke(method, arg);
      });
    });
  }

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);

      if ("throw" !== record.type) {
        var result = record.arg,
            value = result.value;
        return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) {
          invoke("next", value, resolve, reject);
        }, function (err) {
          invoke("throw", err, resolve, reject);
        }) : PromiseImpl.resolve(value).then(function (unwrapped) {
          result.value = unwrapped, resolve(result);
        }, function (error) {
          return invoke("throw", error, resolve, reject);
        });
      }

      reject(record.arg);
    }

    var previousPromise;

    this._invoke = function (method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function (resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg();
    };
  }

  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];

    if (undefined === method) {
      if (context.delegate = null, "throw" === context.method) {
        if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel;
        context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);
    if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel;
    var info = record.arg;
    return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel);
  }

  function pushTryEntry(locs) {
    var entry = {
      tryLoc: locs[0]
    };
    1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal", delete record.arg, entry.completion = record;
  }

  function Context(tryLocsList) {
    this.tryEntries = [{
      tryLoc: "root"
    }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0);
  }

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) return iteratorMethod.call(iterable);
      if ("function" == typeof iterable.next) return iterable;

      if (!isNaN(iterable.length)) {
        var i = -1,
            next = function next() {
          for (; ++i < iterable.length;) {
            if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next;
          }

          return next.value = undefined, next.done = !0, next;
        };

        return next.next = next;
      }
    }

    return {
      next: doneResult
    };
  }

  function doneResult() {
    return {
      value: undefined,
      done: !0
    };
  }

  return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) {
    var ctor = "function" == typeof genFun && genFun.constructor;
    return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name));
  }, exports.mark = function (genFun) {
    return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun;
  }, exports.awrap = function (arg) {
    return {
      __await: arg
    };
  }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () {
    return this;
  }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    void 0 === PromiseImpl && (PromiseImpl = Promise);
    var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl);
    return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) {
      return result.done ? result.value : iter.next();
    });
  }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () {
    return this;
  }), define(Gp, "toString", function () {
    return "[object Generator]";
  }), exports.keys = function (object) {
    var keys = [];

    for (var key in object) {
      keys.push(key);
    }

    return keys.reverse(), function next() {
      for (; keys.length;) {
        var key = keys.pop();
        if (key in object) return next.value = key, next.done = !1, next;
      }

      return next.done = !0, next;
    };
  }, exports.values = values, Context.prototype = {
    constructor: Context,
    reset: function reset(skipTempReset) {
      if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) {
        "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined);
      }
    },
    stop: function stop() {
      this.done = !0;
      var rootRecord = this.tryEntries[0].completion;
      if ("throw" === rootRecord.type) throw rootRecord.arg;
      return this.rval;
    },
    dispatchException: function dispatchException(exception) {
      if (this.done) throw exception;
      var context = this;

      function handle(loc, caught) {
        return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i],
            record = entry.completion;
        if ("root" === entry.tryLoc) return handle("end");

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc"),
              hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
            if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
          } else {
            if (!hasFinally) throw new Error("try statement without catch or finally");
            if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
          }
        }
      }
    },
    abrupt: function abrupt(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];

        if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null);
      var record = finallyEntry ? finallyEntry.completion : {};
      return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record);
    },
    complete: function complete(record, afterLoc) {
      if ("throw" === record.type) throw record.arg;
      return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel;
    },
    finish: function finish(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel;
      }
    },
    "catch": function _catch(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];

        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;

          if ("throw" === record.type) {
            var thrown = record.arg;
            resetTryEntry(entry);
          }

          return thrown;
        }
      }

      throw new Error("illegal catch attempt");
    },
    delegateYield: function delegateYield(iterable, resultName, nextLoc) {
      return this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      }, "next" === this.method && (this.arg = undefined), ContinueSentinel;
    }
  }, exports;
}

module.exports = _regeneratorRuntime, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 9489:
/***/ (function(module) {

function _setPrototypeOf(o, p) {
  module.exports = _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports;
  return _setPrototypeOf(o, p);
}

module.exports = _setPrototypeOf, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 3038:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var arrayWithHoles = __webpack_require__(2858);

var iterableToArrayLimit = __webpack_require__(3884);

var unsupportedIterableToArray = __webpack_require__(379);

var nonIterableRest = __webpack_require__(521);

function _slicedToArray(arr, i) {
  return arrayWithHoles(arr) || iterableToArrayLimit(arr, i) || unsupportedIterableToArray(arr, i) || nonIterableRest();
}

module.exports = _slicedToArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 319:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var arrayWithoutHoles = __webpack_require__(3646);

var iterableToArray = __webpack_require__(6860);

var unsupportedIterableToArray = __webpack_require__(379);

var nonIterableSpread = __webpack_require__(8206);

function _toConsumableArray(arr) {
  return arrayWithoutHoles(arr) || iterableToArray(arr) || unsupportedIterableToArray(arr) || nonIterableSpread();
}

module.exports = _toConsumableArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 8:
/***/ (function(module) {

function _typeof(obj) {
  "@babel/helpers - typeof";

  return (module.exports = _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) {
    return typeof obj;
  } : function (obj) {
    return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports), _typeof(obj);
}

module.exports = _typeof, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 379:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var arrayLikeToArray = __webpack_require__(7228);

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return arrayLikeToArray(o, minLen);
}

module.exports = _unsupportedIterableToArray, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ 7757:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

module.exports = __webpack_require__(9591)();


/***/ }),

/***/ 2608:
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";


var _interopRequireDefault = __webpack_require__(5318);

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

var _regenerator = _interopRequireDefault(__webpack_require__(7757));

var _slicedToArray2 = _interopRequireDefault(__webpack_require__(3038));

var _toConsumableArray2 = _interopRequireDefault(__webpack_require__(319));

var _asyncToGenerator2 = _interopRequireDefault(__webpack_require__(8926));

var _defineProperty2 = _interopRequireDefault(__webpack_require__(9713));

var _classCallCheck2 = _interopRequireDefault(__webpack_require__(4575));

var _createClass2 = _interopRequireDefault(__webpack_require__(3913));

var _uniqueId2 = _interopRequireDefault(__webpack_require__(3955));

var _domTemplate = _interopRequireDefault(__webpack_require__(7726));

var _isHtmlElement = _interopRequireDefault(__webpack_require__(854));

var _overlay = _interopRequireDefault(__webpack_require__(8945));

var _preloader = _interopRequireDefault(__webpack_require__(9357));

var _interaction = _interopRequireDefault(__webpack_require__(4462));

var _control = _interopRequireDefault(__webpack_require__(1298));

var _tooltip = _interopRequireDefault(__webpack_require__(9176));

var _progressbar = _interopRequireDefault(__webpack_require__(7705));

var _title = _interopRequireDefault(__webpack_require__(2844));

var _description = _interopRequireDefault(__webpack_require__(4127));

var _customButtons = _interopRequireDefault(__webpack_require__(7185));

var _previous2 = _interopRequireDefault(__webpack_require__(1439));

var _pagination = _interopRequireDefault(__webpack_require__(2994));

var _next2 = _interopRequireDefault(__webpack_require__(8511));

var _close = _interopRequireDefault(__webpack_require__(3636));

var _copyright = _interopRequireDefault(__webpack_require__(3251));

var _notification = _interopRequireDefault(__webpack_require__(2127));

var _fakeStep = _interopRequireDefault(__webpack_require__(7159));

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { (0, _defineProperty2.default)(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

var GuideChimp = /*#__PURE__*/function () {
  /**
   * GuideChimp constructor
   * @param tour
   * @param options
   */
  function GuideChimp(tour) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    (0, _classCallCheck2.default)(this, GuideChimp);
    Object.defineProperty(this, 'uid', {
      value: (0, _uniqueId2.default)(),
      enumerable: false,
      configurable: false,
      writable: false
    });
    this.setDefaults();
    this.cache = new Map();
    this.listeners = {};
    this.observers = {};
    this.options = {};
    this.setOptions(options);
    this.tour = null;
    this.setTour(tour);
    this.notifications = [];
    this.elements = new Map();
    this.init();
  }
  /**
   * Called after construction, this hook allows you to add some extra setup
   * logic without having to override the constructor.
   */


  (0, _createClass2.default)(GuideChimp, [{
    key: "init",
    value: function init() {}
    /**
     * Default options
     * @return {Object}
     */

  }, {
    key: "setDefaults",
    value: function setDefaults() {
      this.previousStep = null;
      this.currentStep = null;
      this.nextStep = null;
      this.fromStep = null;
      this.toStep = null;
      this.previousStepIndex = -1;
      this.currentStepIndex = -1;
      this.nextStepIndex = -1;
      this.fromStepIndex = -1;
      this.toStepIndex = -1;
      this.steps = [];
      this.isDisplayed = false;
      return this;
    }
    /**
     * Set tour name or steps
     * @param tour
     * @return {this}
     */

  }, {
    key: "setTour",
    value: function setTour(tour) {
      this.tour = tour;
      return this;
    }
    /**
     * Get tour name or steps
     */

  }, {
    key: "getTour",
    value: function getTour() {
      return this.tour;
    }
    /**
     * Set tour options
     * @param options
     * @return {this}
     */

  }, {
    key: "setOptions",
    value: function setOptions(options) {
      this.options = _objectSpread(_objectSpread({}, this.constructor.getDefaultOptions()), options);
      return this;
    }
    /**
     * Get tour options
     */

  }, {
    key: "getOptions",
    value: function getOptions() {
      return this.options;
    }
    /**
     * Start tour
     * @param number step number or it index
     * @param useIndex whether to use step number or index
     * @return {Promise<boolean>}
     */

  }, {
    key: "start",
    value: function () {
      var _start = (0, _asyncToGenerator2.default)( /*#__PURE__*/_regenerator.default.mark(function _callee() {
        var number,
            useIndex,
            _len,
            args,
            _key,
            isStarted,
            _args = arguments;

        return _regenerator.default.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                number = _args.length > 0 && _args[0] !== undefined ? _args[0] : 0;
                useIndex = _args.length > 1 && _args[1] !== undefined ? _args[1] : true;
                this.isDisplayed = true;
                this.mountOverlayEl();
                this.startPreloader(); // emit start event

                for (_len = _args.length, args = new Array(_len > 2 ? _len - 2 : 0), _key = 2; _key < _len; _key++) {
                  args[_key - 2] = _args[_key];
                }

                _context.next = 8;
                return this.emit.apply(this, ['onStart'].concat(args));

              case 8:
                this.stopPreloader();

                if (!(!this.tour || !this.tour.length)) {
                  _context.next = 13;
                  break;
                }

                this.removeOverlayEl();
                this.isDisplayed = false;
                return _context.abrupt("return", false);

              case 13:
                this.steps = this.sortSteps(this.getSteps(this.tour));

                if (this.steps.length) {
                  _context.next = 18;
                  break;
                }

                this.removeOverlayEl();
                this.isDisplayed = false;
                return _context.abrupt("return", false);

              case 18:
                // add a class that increase the specificity of the classes
                document.body.classList.add(this.constructor.getBodyClass());
                _context.next = 21;
                return this.go.apply(this, [number, useIndex].concat(args));

              case 21:
                isStarted = _context.sent;
                this.isDisplayed = isStarted;
                document.body.classList.toggle(this.constructor.getBodyClass(), isStarted);

                if (isStarted) {
                  // turn on keyboard navigation
                  if (this.options.useKeyboard) {
                    this.addOnKeydownListener();
                  } // on window resize


                  this.addOnWindowResizeListener(); // on window scroll

                  this.addOnWindowScrollListener();
                }

                return _context.abrupt("return", isStarted);

              case 26:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function start() {
        return _start.apply(this, arguments);
      }

      return start;
    }()
    /**
     * Go to step
     * @param number step number or it index
     * @param useIndex whether to use step number or index
     * @param args
     * @return {Promise<boolean>}
     */

  }, {
    key: "go",
    value: function () {
      var _go = (0, _asyncToGenerator2.default)( /*#__PURE__*/_regenerator.default.mark(function _callee2(number) {
        var _this = this;

        var useIndex,
            _len2,
            args,
            _key2,
            stepNumber,
            isSameStep,
            fromStep,
            fromStepIndex,
            currentStep,
            currentStepIndex,
            toStep,
            toStepIndex,
            onBeforeChange,
            onAfterChange,
            abort,
            scrollBehavior,
            _this$currentStep$scr,
            scrollPadding,
            _args2 = arguments;

        return _regenerator.default.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                useIndex = _args2.length > 1 && _args2[1] !== undefined ? _args2[1] : true;

                for (_len2 = _args2.length, args = new Array(_len2 > 2 ? _len2 - 2 : 0), _key2 = 2; _key2 < _len2; _key2++) {
                  args[_key2 - 2] = _args2[_key2];
                }

                if (!(!this.isDisplayed || !this.steps.length)) {
                  _context2.next = 4;
                  break;
                }

                return _context2.abrupt("return", false);

              case 4:
                stepNumber = useIndex ? parseInt(number, 10) : number;

                if (!this.currentStep) {
                  _context2.next = 9;
                  break;
                }

                // skip if this step is already displayed
                isSameStep = useIndex ? this.currentStepIndex === stepNumber : this.currentStep.step === stepNumber;

                if (!isSameStep) {
                  _context2.next = 9;
                  break;
                }

                return _context2.abrupt("return", false);

              case 9:
                fromStep = this.currentStep;
                fromStepIndex = this.currentStepIndex;
                currentStep = useIndex ? this.steps[stepNumber] : this.steps.filter(function (_ref) {
                  var step = _ref.step;
                  return step === stepNumber;
                })[0];

                if (currentStep) {
                  _context2.next = 14;
                  break;
                }

                return _context2.abrupt("return", false);

              case 14:
                currentStepIndex = this.steps.indexOf(currentStep);
                toStep = currentStep;
                toStepIndex = currentStepIndex;
                onBeforeChange = toStep.onBeforeChange, onAfterChange = toStep.onAfterChange;
                this.startPreloader();
                abort = false;

                if (!onBeforeChange) {
                  _context2.next = 26;
                  break;
                }

                _context2.next = 23;
                return Promise.resolve().then(function () {
                  return onBeforeChange.call.apply(onBeforeChange, [_this, toStep, fromStep].concat(args));
                });

              case 23:
                _context2.t0 = _context2.sent;

                if (!(_context2.t0 === false)) {
                  _context2.next = 26;
                  break;
                }

                abort = true;

              case 26:
                _context2.next = 28;
                return this.emit.apply(this, ['onBeforeChange', toStep, fromStep].concat(args));

              case 28:
                if (!_context2.sent.some(function (r) {
                  return r === false;
                })) {
                  _context2.next = 30;
                  break;
                }

                abort = true;

              case 30:
                this.stopPreloader();

                if (!abort) {
                  _context2.next = 33;
                  break;
                }

                return _context2.abrupt("return", false);

              case 33:
                this.beforeChangeStep({
                  toStep: toStep,
                  toStepIndex: toStepIndex,
                  currentStep: currentStep,
                  currentStepIndex: currentStepIndex,
                  fromStep: fromStep,
                  fromStepIndex: fromStepIndex
                });
                this.toStep = toStep;
                this.toStepIndex = toStepIndex;
                this.currentStep = currentStep;
                this.currentStepIndex = currentStepIndex;
                this.fromStep = fromStep;
                this.fromStepIndex = fromStepIndex;
                this.previousStep = this.steps[this.currentStepIndex - 1] || null;
                this.previousStepIndex = this.previousStep ? this.currentStepIndex - 1 : -1;
                this.nextStep = this.steps[this.currentStepIndex + 1] || null;
                this.nextStepIndex = this.nextStep ? this.currentStepIndex + 1 : -1;
                scrollBehavior = this.options.scrollBehavior;
                _this$currentStep$scr = this.currentStep.scrollPadding, scrollPadding = _this$currentStep$scr === void 0 ? this.options.scrollPadding : _this$currentStep$scr; // scroll to element

                this.scrollParentsToStepEl();
                this.scrollTo(this.getStepEl(this.currentStep, true), scrollBehavior, scrollPadding);
                this.mountStep();
                setTimeout(function () {
                  if (_this.getEl('tooltip')) {
                    _this.scrollTo(_this.getEl('tooltip'), scrollBehavior, scrollPadding);
                  }
                }, 300);

                if (onAfterChange) {
                  onAfterChange.call.apply(onAfterChange, [this, this.toStep, this.fromStep].concat(args));
                }

                this.emit.apply(this, ['onAfterChange', this.toStep, this.fromStep].concat(args));
                return _context2.abrupt("return", true);

              case 53:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function go(_x) {
        return _go.apply(this, arguments);
      }

      return go;
    }()
  }, {
    key: "previous",
    value: function () {
      var _previous = (0, _asyncToGenerator2.default)( /*#__PURE__*/_regenerator.default.mark(function _callee3() {
        var _this2 = this;

        var _len3,
            args,
            _key3,
            onPrevious,
            _args3 = arguments;

        return _regenerator.default.wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                for (_len3 = _args3.length, args = new Array(_len3), _key3 = 0; _key3 < _len3; _key3++) {
                  args[_key3] = _args3[_key3];
                }

                if (!(!this.isDisplayed || !this.currentStep || !this.previousStep)) {
                  _context3.next = 3;
                  break;
                }

                return _context3.abrupt("return", false);

              case 3:
                onPrevious = this.currentStep.onPrevious;
                this.startPreloader();

                if (!onPrevious) {
                  _context3.next = 12;
                  break;
                }

                _context3.next = 8;
                return Promise.resolve().then(function () {
                  return onPrevious.call.apply(onPrevious, [_this2, _this2.previousStep, _this2.currentStep].concat(args));
                });

              case 8:
                _context3.t0 = _context3.sent;

                if (!(_context3.t0 === false)) {
                  _context3.next = 12;
                  break;
                }

                this.stopPreloader();
                return _context3.abrupt("return", false);

              case 12:
                _context3.next = 14;
                return this.emit.apply(this, ['onPrevious', this.previousStep, this.currentStep].concat(args));

              case 14:
                if (!_context3.sent.some(function (r) {
                  return r === false;
                })) {
                  _context3.next = 17;
                  break;
                }

                this.stopPreloader();
                return _context3.abrupt("return", false);

              case 17:
                this.stopPreloader();
                return _context3.abrupt("return", this.go.apply(this, [this.previousStepIndex, true].concat(args)));

              case 19:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));

      function previous() {
        return _previous.apply(this, arguments);
      }

      return previous;
    }()
  }, {
    key: "next",
    value: function () {
      var _next = (0, _asyncToGenerator2.default)( /*#__PURE__*/_regenerator.default.mark(function _callee4() {
        var _this3 = this;

        var _len4,
            args,
            _key4,
            onNext,
            _args4 = arguments;

        return _regenerator.default.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                for (_len4 = _args4.length, args = new Array(_len4), _key4 = 0; _key4 < _len4; _key4++) {
                  args[_key4] = _args4[_key4];
                }

                if (!(!this.isDisplayed || !this.currentStep || !this.nextStep)) {
                  _context4.next = 3;
                  break;
                }

                return _context4.abrupt("return", false);

              case 3:
                onNext = this.currentStep.onNext;
                this.startPreloader();

                if (!onNext) {
                  _context4.next = 12;
                  break;
                }

                _context4.next = 8;
                return Promise.resolve().then(function () {
                  return onNext.call.apply(onNext, [_this3, _this3.nextStep, _this3.currentStep].concat(args));
                });

              case 8:
                _context4.t0 = _context4.sent;

                if (!(_context4.t0 === false)) {
                  _context4.next = 12;
                  break;
                }

                this.stopPreloader();
                return _context4.abrupt("return", false);

              case 12:
                _context4.next = 14;
                return this.emit.apply(this, ['onNext', this.nextStep, this.currentStep].concat(args));

              case 14:
                if (!_context4.sent.some(function (r) {
                  return r === false;
                })) {
                  _context4.next = 17;
                  break;
                }

                this.stopPreloader();
                return _context4.abrupt("return", false);

              case 17:
                this.stopPreloader();
                return _context4.abrupt("return", this.go.apply(this, [this.nextStepIndex, true].concat(args)));

              case 19:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, this);
      }));

      function next() {
        return _next.apply(this, arguments);
      }

      return next;
    }()
  }, {
    key: "stop",
    value: function () {
      var _stop = (0, _asyncToGenerator2.default)( /*#__PURE__*/_regenerator.default.mark(function _callee5() {
        var _len5,
            args,
            _key5,
            _args5 = arguments;

        return _regenerator.default.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                if (this.isDisplayed) {
                  _context5.next = 2;
                  break;
                }

                return _context5.abrupt("return", this);

              case 2:
                for (_len5 = _args5.length, args = new Array(_len5), _key5 = 0; _key5 < _len5; _key5++) {
                  args[_key5] = _args5[_key5];
                }

                if (!(this.currentStepIndex === this.steps.length - 1)) {
                  _context5.next = 8;
                  break;
                }

                this.startPreloader();
                _context5.next = 7;
                return this.emit.apply(this, ['onComplete'].concat(args));

              case 7:
                this.stopPreloader();

              case 8:
                this.startPreloader(); // emit stop event

                _context5.next = 11;
                return this.emit.apply(this, ['onStop'].concat(args));

              case 11:
                this.stopPreloader(); // remove the class that increase the specificity of the classes

                document.body.classList.remove(this.constructor.getBodyClass()); // remove events listeners

                this.removeListeners(); // disconnect observers

                this.unobserveStep(); // remove all layers and keys

                this.unmountStep(); // remove overlay

                this.removeOverlayEl();
                this.cache.clear();
                this.elements.clear(); // set step variables to defaults

                this.setDefaults();
                return _context5.abrupt("return", this);

              case 21:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, this);
      }));

      function stop() {
        return _stop.apply(this, arguments);
      }

      return stop;
    }()
  }, {
    key: "getSteps",
    value: function getSteps(tour) {
      if (!tour || !tour.length) {
        return [];
      }

      return typeof tour === 'string' ? this.getDataSteps(tour) : this.getJsSteps(tour);
    }
  }, {
    key: "getDataSteps",
    value: function getDataSteps(tour) {
      var _this4 = this;

      var dataPrefix = 'data-guidechimp';
      var tourStepsEl = Array.from(document.querySelectorAll("[".concat(dataPrefix, "-tour*='").concat(tour, "']"))); // filter steps by tour name

      tourStepsEl = tourStepsEl.filter(function (v) {
        var tours = v.getAttribute("".concat(dataPrefix, "-tour")).split(',');
        return tours.includes(_this4.tour);
      });
      var dataTourRegExp = new RegExp("^".concat(dataPrefix, "-").concat(tour, "-[^-]+$"));
      var dataGlobalRegExp = new RegExp("^".concat(dataPrefix, "-[^-]+$"));
      return tourStepsEl.map(function (el, i) {
        var stepAttrs = {};

        for (var j = 0; j < el.attributes.length; j++) {
          var _el$attributes$j = el.attributes[j],
              attrName = _el$attributes$j.name,
              attrValue = _el$attributes$j.value;
          var isTourAttr = dataTourRegExp.test(attrName);
          var isGlobalAttr = isTourAttr ? false : dataGlobalRegExp.test(attrName);

          if (isTourAttr || isGlobalAttr) {
            var attrShortName = isTourAttr ? attrName.replace("".concat(dataPrefix, "-").concat(tour, "-"), '') : attrName.replace("".concat(dataPrefix, "-"), '');

            if (attrShortName !== 'tour') {
              if (isTourAttr || isGlobalAttr && !stepAttrs[attrShortName]) {
                stepAttrs[attrShortName] = attrValue;
              }
            }
          }
        }

        return _objectSpread(_objectSpread({
          step: i,
          title: '',
          description: '',
          position: _this4.options.position,
          interaction: _this4.options.interaction
        }, stepAttrs), {}, {
          element: el
        });
      });
    }
  }, {
    key: "getJsSteps",
    value: function getJsSteps(tour) {
      return tour.map(function (v, i) {
        return _objectSpread(_objectSpread({}, v), {}, {
          step: v.step || i
        });
      });
    }
  }, {
    key: "sortSteps",
    value: function sortSteps(steps) {
      var copy = (0, _toConsumableArray2.default)(steps);
      return copy.sort(function (a, b) {
        if (a.step < b.step) {
          return -1;
        }

        if (a.step > b.step) {
          return 1;
        }

        return 0;
      });
    }
  }, {
    key: "getStepEl",
    value: function getStepEl(step) {
      var _ref2 = step || {},
          element = _ref2.element;

      if (!element) {
        return this.mountFakeStepEl();
      }

      var getEl = function getEl(selector) {
        var def = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
        var el = typeof selector === 'string' ? document.querySelector(selector) : selector;
        return el || def;
      };

      var el = getEl(element);

      if (!el || el.style.display === 'none' || el.style.visibility === 'hidden') {
        el = this.getEl('fakeStep') ? this.getEl('fakeStep') : this.mountFakeStepEl();
      }

      return el;
    }
  }, {
    key: "scrollParentsToStepEl",
    value: function scrollParentsToStepEl() {
      var _this$currentStep$scr2 = this.currentStep.scrollPadding,
          scrollPadding = _this$currentStep$scr2 === void 0 ? this.options.scrollPadding : _this$currentStep$scr2;
      return this.scrollParentsToEl(this.getStepEl(this.currentStep), scrollPadding);
    }
  }, {
    key: "getScrollableParentsEls",
    value: function getScrollableParentsEls(el) {
      var parents = [];
      var htmlEl = el;

      while (htmlEl && htmlEl !== htmlEl.ownerDocument.body) {
        htmlEl = this.getScrollableParentEl(htmlEl);
        parents.push(htmlEl);
      }

      return parents;
    }
  }, {
    key: "getScrollableParentEl",
    value: function getScrollableParentEl(el) {
      var regex = /(auto|scroll)/;
      var elStyle = getComputedStyle(el);
      var elDocument = el.ownerDocument;

      var getClosestScrollableParent = function getClosestScrollableParent(parent) {
        if (!parent || parent === elDocument.body) {
          return elDocument.body;
        }

        var parentStyle = getComputedStyle(parent);

        if (elStyle.getPropertyValue('position') === 'fixed' && parentStyle.getPropertyValue('position') === 'static') {
          return getClosestScrollableParent(parent.parentElement);
        }

        var overflowX = parentStyle.getPropertyValue('overflow-x');
        var overflowY = parentStyle.getPropertyValue('overflow-y');

        if (regex.test(overflowX) || regex.test(overflowY)) {
          return parent;
        }

        return getClosestScrollableParent(parent.parentElement);
      };

      return elStyle.getPropertyValue('position') === 'fixed' ? elDocument.body : getClosestScrollableParent(el.parentElement);
    }
  }, {
    key: "scrollParentsToEl",
    value: function scrollParentsToEl(el) {
      var scrollPadding = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
      // get all scrollable parents
      var parents = this.getScrollableParentsEls(el);
      parents.forEach(function (parent) {
        if (parent !== document.body) {
          // eslint-disable-next-line no-param-reassign
          parent.scrollTop = el.offsetTop - parent.offsetTop - scrollPadding; // eslint-disable-next-line no-param-reassign

          parent.scrollLeft = el.offsetLeft - parent.offsetLeft - scrollPadding;
        }
      });
      return this;
    }
  }, {
    key: "scrollTo",
    value: function scrollTo(el) {
      var behavior = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'auto';
      var scrollPadding = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;

      var _el$getBoundingClient = el.getBoundingClientRect(),
          top = _el$getBoundingClient.top,
          bottom = _el$getBoundingClient.bottom,
          left = _el$getBoundingClient.left,
          right = _el$getBoundingClient.right;

      var _window = window,
          innerWidth = _window.innerWidth,
          innerHeight = _window.innerHeight;

      if (!(left >= 0 && right <= innerWidth)) {
        window.scrollBy({
          behavior: behavior,
          left: left - scrollPadding
        });
      }

      if (!(top >= 0 && bottom <= innerHeight)) {
        window.scrollBy({
          behavior: behavior,
          top: top - scrollPadding
        });
      }

      return this;
    }
  }, {
    key: "highlightStepEl",
    value: function highlightStepEl() {
      var animation = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      var el = this.getStepEl(this.currentStep);
      var overlay = this.getEl('overlay');

      if (overlay) {
        var path = overlay.querySelector('path');
        var animate = path.querySelector('animate');
        var isCurrentElFake = this.isEl(el, 'fakeStep');
        var to = isCurrentElFake ? this.getOverlayDocumentPath() : this.getOverlayStepPath(this.currentStep);
        path.setAttribute('d', to);

        if (animate) {
          var lock = animate.getAttribute('lock');

          if (!lock) {
            animate.setAttribute('from', to);
            animate.setAttribute('to', to);
          }

          if (animation) {
            var isFromElFake = this.isEl(this.getStepEl(this.fromStep), 'fakeStep');
            var from = this.fromStep && !isFromElFake && !isCurrentElFake ? this.getOverlayStepPath(this.fromStep) : null;

            if (from) {
              animate.setAttribute('from', from);
              animate.setAttribute('to', to);
            }

            animate.setAttribute('lock', 'true');
          }

          animate.onend = function () {
            animate.removeAttribute('lock');
          };

          animate.beginElement();
        }
      }

      var elStyle = getComputedStyle(el);

      if (!['absolute', 'relative', 'fixed'].includes(elStyle.getPropertyValue('position'))) {
        el.classList.add(this.constructor.getRelativePositionClass());
      }

      el.classList.add(this.constructor.getHighlightClass());
      el.setAttribute("data-guidechimp-".concat(this.uid), 'highlight');
      this.elements.set('highlight', el);
      return this;
    }
  }, {
    key: "resetHighlightStepEl",
    value: function resetHighlightStepEl() {
      var overlay = this.getEl('overlay');

      if (overlay) {
        var path = overlay.querySelector('path');
        var animate = overlay.querySelector('animate');
        path.setAttribute('d', this.getOverlayDocumentPath());

        if (animate) {
          animate.removeAttribute('from');
          animate.removeAttribute('to');
        }
      }

      var el = this.getStepEl(this.currentStep);
      el.classList.remove(this.constructor.getRelativePositionClass());
      el.classList.remove(this.constructor.getHighlightClass());
      el.removeAttribute("data-guidechimp-".concat(this.uid));
      this.elements.delete('highlight');
      return this;
    }
  }, {
    key: "setInteractionPosition",
    value: function setInteractionPosition(interactionEl) {
      var el = this.getStepEl(this.currentStep);

      if (!interactionEl || !el) {
        return this;
      }

      var padding = this.options.padding;
      var elStyle = getComputedStyle(el);

      if (elStyle.getPropertyValue('position') === 'floating') {
        padding = 0;
      }

      var _this$constructor$get = this.constructor.getOffset(el),
          width = _this$constructor$get.width,
          height = _this$constructor$get.height,
          top = _this$constructor$get.top,
          left = _this$constructor$get.left;

      interactionEl.classList.toggle(this.constructor.getFixedClass(), this.constructor.isFixed(el));
      var style = interactionEl.style; // set new position

      style.cssText = "width: ".concat(width + padding, "px;\n        height: ").concat(height + padding, "px;\n        top: ").concat(top - padding / 2, "px;\n        left: ").concat(left - padding / 2, "px;");
      return this;
    }
  }, {
    key: "setControlPosition",
    value: function setControlPosition(controlEl) {
      var el = this.getStepEl(this.currentStep);

      if (!controlEl || !el) {
        return this;
      }

      var padding = this.options.padding;
      var elStyle = getComputedStyle(el);

      if (elStyle.getPropertyValue('position') === 'floating') {
        padding = 0;
      }

      var pageXOffset = el.ownerDocument.defaultView.pageXOffset;

      var _el$ownerDocument$doc = el.ownerDocument.documentElement.getBoundingClientRect(),
          docElWidth = _el$ownerDocument$doc.width;

      var _this$constructor$get2 = this.constructor.getOffset(el),
          elHeight = _this$constructor$get2.height,
          elTop = _this$constructor$get2.top,
          elLeft = _this$constructor$get2.left,
          elRight = _this$constructor$get2.right;

      var height = elHeight + padding;
      var top = elTop - padding / 2;
      var left = pageXOffset < pageXOffset + (elLeft - padding / 2) ? pageXOffset : elLeft - padding / 2;
      var width = pageXOffset + docElWidth > pageXOffset + (elRight + padding / 2) ? docElWidth : elRight + padding / 2;
      controlEl.classList.toggle(this.constructor.getFixedClass(), this.constructor.isFixed(el));
      var style = controlEl.style; // set new position

      style.cssText = "width: ".concat(width, "px;\n        height: ").concat(height, "px;\n        top: ").concat(top, "px;\n        left: ").concat(left, "px;");
      return this;
    }
  }, {
    key: "setTooltipPosition",
    value: function setTooltipPosition(tooltipEl) {
      var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

      if (!this.currentStep) {
        return this;
      }

      var el = this.getStepEl(this.currentStep);

      if (!tooltipEl || !el) {
        return this;
      }

      var boundary = options.boundary,
          pos = options.position;
      var padding = this.options.padding;
      boundary = boundary || window;
      pos = pos || this.currentStep.position;
      pos = pos || this.options.position;

      var _pos$split = pos.split('-'),
          _pos$split2 = (0, _slicedToArray2.default)(_pos$split, 2),
          position = _pos$split2[0],
          alignment = _pos$split2[1];

      var elStyle = getComputedStyle(el);

      if (elStyle.getPropertyValue('position') === 'floating') {
        padding = 0;
      }

      var tooltipStyle = tooltipEl.style; // reset tooltip styles

      tooltipStyle.top = null;
      tooltipStyle.right = null;
      tooltipStyle.bottom = null;
      tooltipStyle.left = null;
      tooltipStyle.transform = null;

      var _el$getBoundingClient2 = el.getBoundingClientRect(),
          elTop = _el$getBoundingClient2.top,
          elBottom = _el$getBoundingClient2.bottom,
          elLeft = _el$getBoundingClient2.left,
          elRight = _el$getBoundingClient2.right,
          elWidth = _el$getBoundingClient2.width,
          elHeight = _el$getBoundingClient2.height;

      var _tooltipEl$getBoundin = tooltipEl.getBoundingClientRect(),
          tooltipHeight = _tooltipEl$getBoundin.height,
          tooltipWith = _tooltipEl$getBoundin.width; // find out min tooltip width


      var cloneTooltip = tooltipEl.cloneNode(true);
      cloneTooltip.style.visibility = 'hidden';
      cloneTooltip.innerHTML = '';
      tooltipEl.parentElement.appendChild(cloneTooltip);

      var _cloneTooltip$getBoun = cloneTooltip.getBoundingClientRect(),
          minTooltipWidth = _cloneTooltip$getBoun.width;

      cloneTooltip.parentElement.removeChild(cloneTooltip);
      var boundaryRect = new DOMRect(0, 0, window.innerWidth, window.innerHeight);

      if (!(boundary instanceof Window)) {
        var _boundary$getBounding = boundary.getBoundingClientRect(),
            x = _boundary$getBounding.x,
            y = _boundary$getBounding.y;

        boundaryRect = new DOMRect(x, y, boundary.scrollWidth, boundary.scrollHeight);
      }

      var _boundaryRect = boundaryRect,
          boundaryTop = _boundaryRect.top,
          boundaryBottom = _boundaryRect.bottom,
          boundaryLeft = _boundaryRect.left,
          boundaryRight = _boundaryRect.right; // if the element is default element, skip position and alignment calculation

      if (this.isEl(el, 'fakeStep')) {
        position = 'floating';
      } else {
        // calculate position
        var positions = ['bottom', 'right', 'left', 'top'];

        var _getComputedStyle = getComputedStyle(tooltipEl),
            tooltipMarginTop = _getComputedStyle.marginTop,
            tooltipMarginLeft = _getComputedStyle.marginLeft,
            tooltipMarginRight = _getComputedStyle.marginRight,
            tooltipMarginBottom = _getComputedStyle.marginBottom;

        tooltipMarginTop = parseInt(tooltipMarginTop, 10);
        tooltipMarginLeft = parseInt(tooltipMarginLeft, 10);
        tooltipMarginRight = parseInt(tooltipMarginRight, 10);
        tooltipMarginBottom = parseInt(tooltipMarginBottom, 10); // check if the tooltip can be placed on top

        if (tooltipHeight + tooltipMarginTop + tooltipMarginBottom > elTop - boundaryTop) {
          positions.splice(positions.indexOf('top'), 1);
        } // check if the tooltip can be placed on bottom


        if (tooltipHeight + tooltipMarginTop + tooltipMarginBottom > boundaryBottom - elBottom) {
          positions.splice(positions.indexOf('bottom'), 1);
        } // check if the tooltip can be placed on left


        if (minTooltipWidth + tooltipMarginLeft + tooltipMarginRight > elLeft - boundaryLeft) {
          positions.splice(positions.indexOf('left'), 1);
        } // check if the tooltip can be placed on right


        if (minTooltipWidth + tooltipMarginLeft + tooltipMarginRight > boundaryRight - elRight) {
          positions.splice(positions.indexOf('right'), 1);
        }

        if (positions.length) {
          position = positions.includes(position) ? position : positions[0];
        } else {
          position = 'floating';
        }

        if (position === 'top' || position === 'bottom') {
          var alignments = ['left', 'right', 'middle']; // valid left space must be at least tooltip width

          if (boundaryRight - elLeft < minTooltipWidth) {
            alignments.splice(alignments.indexOf('left'), 1);
          } // valid right space must be at least tooltip width


          if (elRight - boundaryLeft < minTooltipWidth) {
            alignments.splice(alignments.indexOf('right'), 1);
          } // valid middle space must be at least half width from both sides


          if (elLeft + elWidth / 2 - boundaryLeft < minTooltipWidth / 2 || boundaryRight - (elRight - elWidth / 2) < minTooltipWidth / 2) {
            alignments.splice(alignments.indexOf('middle'), 1);
          }

          if (alignments.length) {
            alignment = alignments.includes(alignment) ? alignment : alignments[0];
          } else {
            alignment = 'middle';
          }
        }
      }

      tooltipEl.setAttribute('data-guidechimp-position', position);
      var root = document.documentElement;

      switch (position) {
        case 'top':
          tooltipStyle.bottom = "".concat(elHeight + padding, "px");
          break;

        case 'right':
          tooltipStyle.left = "".concat(elRight + padding / 2 - root.clientLeft, "px");
          break;

        case 'left':
          tooltipStyle.right = "".concat(root.clientWidth - (elLeft - padding / 2), "px");
          break;

        case 'bottom':
          tooltipStyle.top = "".concat(elHeight + padding, "px");
          break;

        default:
          {
            tooltipStyle.left = '50%';
            tooltipStyle.top = '50%';
            tooltipStyle.transform = 'translate(-50%,-50%)';
          }
      }

      tooltipEl.removeAttribute('data-guidechimp-alignment');

      if (alignment) {
        tooltipEl.setAttribute('data-guidechimp-alignment', alignment);

        switch (alignment) {
          case 'left':
            {
              tooltipStyle.left = "".concat(elLeft - padding / 2, "px");
              break;
            }

          case 'right':
            {
              tooltipStyle.right = "".concat(root.clientWidth - elRight - padding / 2, "px");
              break;
            }

          default:
            {
              if (elLeft + elWidth / 2 < tooltipWith / 2 || elLeft + elWidth / 2 + tooltipWith / 2 > root.clientWidth) {
                tooltipStyle.left = "".concat(root.clientWidth / 2 - tooltipWith / 2, "px");
              } else {
                tooltipStyle.left = "".concat(elLeft + elWidth / 2 - tooltipWith / 2, "px");
              }
            }
        }
      }

      return this;
    }
  }, {
    key: "startPreloader",
    value: function startPreloader() {
      document.body.classList.add(this.constructor.getLoadingClass());
      var overlay = this.getEl('overlay');

      if (overlay) {
        var path = overlay.querySelector('path');
        var animate = overlay.querySelector('animate');
        var preloaderCache = new Map();
        preloaderCache.set('d', path.getAttribute('d'));
        path.setAttribute('d', this.getOverlayDocumentPath());

        if (animate) {
          preloaderCache.set('from', animate.getAttribute('from'));
          preloaderCache.set('to', animate.getAttribute('to'));
          animate.removeAttribute('from');
          animate.removeAttribute('to');
        }

        this.cache.set('preloaderCache', preloaderCache);
      }

      var preloader = this.mountPreloaderEl();
      preloader.hidden = true;
      setTimeout(function () {
        preloader.hidden = false;
      }, 100);
      return this;
    }
  }, {
    key: "stopPreloader",
    value: function stopPreloader() {
      document.body.classList.remove(this.constructor.getLoadingClass());
      var overlay = this.getEl('overlay');

      if (overlay) {
        var path = overlay.querySelector('path');
        var animate = overlay.querySelector('animate');
        var preloaderCache = this.cache.get('preloaderCache') || new Map();

        if (preloaderCache.has('d')) {
          path.setAttribute('d', preloaderCache.get('d'));
        }

        if (animate) {
          if (preloaderCache.has('from')) {
            animate.setAttribute('from', preloaderCache.get('from'));
          }

          if (preloaderCache.has('to')) {
            animate.setAttribute('to', preloaderCache.get('to'));
          }
        }

        this.cache.delete('preloaderCache');
      }

      this.removePreloaderEl();
      return this;
    }
  }, {
    key: "getDefaultTmplData",
    value: function getDefaultTmplData() {
      var _this5 = this;

      return {
        previousStep: this.previousStep,
        currentStep: this.currentStep,
        nextStep: this.nextStep,
        fromStep: this.fromStep,
        toStep: this.toStep,
        previousStepIndex: this.previousStepIndex,
        currentStepIndex: this.currentStepIndex,
        nextStepIndex: this.nextStepIndex,
        fromStepIndex: this.fromStepIndex,
        toStepIndex: this.toStepIndex,
        steps: this.steps,
        go: function go() {
          return _this5.go.apply(_this5, arguments);
        },
        previous: function previous() {
          return _this5.previous.apply(_this5, arguments);
        },
        next: function next() {
          return _this5.next.apply(_this5, arguments);
        },
        stop: function stop() {
          return _this5.stop.apply(_this5, arguments);
        }
      };
    }
  }, {
    key: "mountStep",
    value: function mountStep() {
      var interactionEl = this.mountInteractionEl();
      var controlEl = this.mountControlEl();
      this.setInteractionPosition(interactionEl);
      this.setControlPosition(controlEl);
      this.setTooltipPosition(this.getEl('tooltip'));
      this.observeStep();
      this.highlightStepEl(true);
      return this;
    }
  }, {
    key: "unmountStep",
    value: function unmountStep() {
      this.resetHighlightStepEl();
      this.removeInteractionEl();
      this.removeControlEl();
      this.removePreloaderEl();
      this.removeFakeStepEl();
      return this;
    }
  }, {
    key: "createEl",
    value: function createEl(name, tmpl) {
      var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
      var el = (0, _domTemplate.default)(tmpl, data);

      if (el) {
        el.setAttribute("data-quidechimp-".concat(this.uid), name);
      }

      return el;
    }
  }, {
    key: "getEl",
    value: function getEl(key) {
      var def = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      var el = this.elements.get(key);

      if (!el) {
        el = document.querySelector("[data-quidechimp-".concat(this.uid, "=\"").concat(key, "\"]"));
      }

      return el || def;
    }
  }, {
    key: "mountEl",
    value: function mountEl(el, parent) {
      var _this6 = this;

      if (el) {
        var els = el.querySelectorAll("[data-quidechimp-".concat(this.uid, "]"));
        [el].concat((0, _toConsumableArray2.default)(els)).forEach(function (v) {
          var key = v.getAttribute("data-quidechimp-".concat(_this6.uid));

          if (key) {
            _this6.removeEl(key);

            _this6.elements.set(key, v);
          }
        });
        parent.appendChild(el);
      }

      return el;
    }
  }, {
    key: "removeEl",
    value: function removeEl(key) {
      var el = this.getEl(key);

      if (el) {
        el.parentElement.removeChild(el);
      }

      this.elements.delete(key);
      return this;
    }
  }, {
    key: "isEl",
    value: function isEl(el, key) {
      return this.getEl(key) ? el === this.getEl(key) : el.getAttribute("data-quidechimp-".concat(this.uid)) === key;
    }
  }, {
    key: "getFakeStepTmpl",
    value: function getFakeStepTmpl() {
      return _fakeStep.default;
    }
  }, {
    key: "createFakeStepEl",
    value: function createFakeStepEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.createEl('fakeStep', this.getFakeStepTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), data));
    }
  }, {
    key: "mountFakeStepEl",
    value: function mountFakeStepEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.mountEl(this.createFakeStepEl(data), document.body);
    }
  }, {
    key: "removeFakeStepEl",
    value: function removeFakeStepEl() {
      return this.removeEl('fakeStep');
    }
  }, {
    key: "getPreloaderTmpl",
    value: function getPreloaderTmpl() {
      return _preloader.default;
    }
  }, {
    key: "createPreloaderEl",
    value: function createPreloaderEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.createEl('preloader', this.getPreloaderTmpl(), data);
    }
  }, {
    key: "mountPreloaderEl",
    value: function mountPreloaderEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.mountEl(this.createPreloaderEl(data), document.body);
    }
  }, {
    key: "removePreloaderEl",
    value: function removePreloaderEl() {
      return this.removeEl('preloader');
    }
  }, {
    key: "getOverlayDocumentPath",
    value: function getOverlayDocumentPath() {
      var _window2 = window,
          innerWidth = _window2.innerWidth,
          innerHeight = _window2.innerHeight;
      var _document = document,
          _document$body = _document.body,
          scrollWidth = _document$body.scrollWidth,
          scrollHeight = _document$body.scrollHeight;
      var width = innerWidth > scrollWidth ? innerWidth : scrollWidth;
      var height = innerHeight > scrollHeight ? innerHeight : scrollHeight;
      return "M 0 0 H ".concat(width, " V ").concat(height, " H 0 V 0 Z");
    }
  }, {
    key: "getOverlayStepPath",
    value: function getOverlayStepPath(step) {
      return this.getOverlayElPath(this.getStepEl(step));
    }
  }, {
    key: "getOverlayElPath",
    value: function getOverlayElPath(el) {
      var padding = this.options.padding;
      padding = padding ? padding / 2 : 0;

      var _el$getBoundingClient3 = el.getBoundingClientRect(),
          left = _el$getBoundingClient3.left,
          top = _el$getBoundingClient3.top,
          width = _el$getBoundingClient3.width,
          height = _el$getBoundingClient3.height;

      var r = 4;
      var path = this.getOverlayDocumentPath();
      path += "M ".concat(left - padding + r, " ").concat(top - padding, "\n                 a ").concat(r, ",").concat(r, " 0 0 0 -").concat(r, ",").concat(r, "\n                 V ").concat(height + top + padding - r, "\n                 a ").concat(r, ",").concat(r, " 0 0 0 ").concat(r, ",").concat(r, "\n                 H ").concat(width + left + padding - r, "\n                 a ").concat(r, ",").concat(r, " 0 0 0 ").concat(r, ",-").concat(r, "\n                 V ").concat(top - padding + r, "\n                 a ").concat(r, ",").concat(r, " 0 0 0 -").concat(r, ",-").concat(r, "Z");
      return path;
    }
  }, {
    key: "getOverlayTmpl",
    value: function getOverlayTmpl() {
      return _overlay.default;
    }
  }, {
    key: "createOverlayEl",
    value: function createOverlayEl() {
      var _this7 = this;

      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var defaults = {
        stop: function () {
          var _stop2 = (0, _asyncToGenerator2.default)( /*#__PURE__*/_regenerator.default.mark(function _callee6() {
            var _args6 = arguments;
            return _regenerator.default.wrap(function _callee6$(_context6) {
              while (1) {
                switch (_context6.prev = _context6.next) {
                  case 0:
                    if (!_this7.options.exitOverlay) {
                      _context6.next = 3;
                      break;
                    }

                    _context6.next = 3;
                    return _this7.stop.apply(_this7, _args6);

                  case 3:
                  case "end":
                    return _context6.stop();
                }
              }
            }, _callee6);
          }));

          function stop() {
            return _stop2.apply(this, arguments);
          }

          return stop;
        }(),
        path: this.getOverlayDocumentPath()
      };
      return this.createEl('overlay', this.getOverlayTmpl(), _objectSpread(_objectSpread({}, defaults), data));
    }
  }, {
    key: "mountOverlayEl",
    value: function mountOverlayEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.mountEl(this.createOverlayEl(data), document.body);
    }
  }, {
    key: "removeOverlayEl",
    value: function removeOverlayEl() {
      return this.removeEl('overlay');
    }
  }, {
    key: "getInteractionTmpl",
    value: function getInteractionTmpl() {
      return _interaction.default;
    }
  }, {
    key: "createInteractionEl",
    value: function createInteractionEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var interaction = this.options.interaction;

      if (typeof this.currentStep.interaction === 'boolean') {
        interaction = this.currentStep.interaction;
      }

      var defaults = _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        interaction: interaction
      });

      return this.createEl('interaction', this.getInteractionTmpl(), _objectSpread(_objectSpread({}, defaults), data));
    }
  }, {
    key: "mountInteractionEl",
    value: function mountInteractionEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.mountEl(this.createInteractionEl(data), document.body);
    }
  }, {
    key: "removeInteractionEl",
    value: function removeInteractionEl() {
      return this.removeEl('interaction');
    }
  }, {
    key: "getControlTmpl",
    value: function getControlTmpl() {
      return _control.default;
    }
  }, {
    key: "createControlEl",
    value: function createControlEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.createEl('control', this.getControlTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        tooltipEl: this.createTooltipEl(data)
      }, data));
    }
  }, {
    key: "mountControlEl",
    value: function mountControlEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.mountEl(this.createControlEl(data), document.body);
    }
  }, {
    key: "removeControlEl",
    value: function removeControlEl() {
      return this.removeEl('control');
    }
  }, {
    key: "getTooltipTmpl",
    value: function getTooltipTmpl() {
      return _tooltip.default;
    }
  }, {
    key: "createTooltipEl",
    value: function createTooltipEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

      var defaults = _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        progressbar: this.createProgressbarEl(data),
        title: this.createTitleEl(data),
        description: this.createDescriptionEl(data),
        close: this.createCloseEl(data),
        customButtons: this.createCustomButtonsEl(data),
        previous: this.createPreviousEl(data),
        pagination: this.createPaginationEl(data),
        next: this.createNextEl(data),
        copyright: this.createCopyrightEl(data),
        notification: this.createNotificationEl(data)
      });

      return this.createEl('tooltip', this.getTooltipTmpl(), _objectSpread(_objectSpread({}, defaults), data));
    }
  }, {
    key: "getCloseTmpl",
    value: function getCloseTmpl() {
      return _close.default;
    }
  }, {
    key: "createCloseEl",
    value: function createCloseEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.createEl('close', this.getCloseTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), data));
    }
  }, {
    key: "getProgressbarTmpl",
    value: function getProgressbarTmpl() {
      return _progressbar.default;
    }
  }, {
    key: "createProgressbarEl",
    value: function createProgressbarEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var showProgressbar = this.options.showProgressbar;

      if (typeof this.currentStep.showProgressbar === 'boolean') {
        showProgressbar = this.currentStep.showProgressbar;
      }

      var progressMax = 100;
      var progressMin = 0;
      var progress = (this.currentStepIndex + 1) / this.steps.length * 100;

      var defaults = _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        showProgressbar: showProgressbar,
        progressMax: progressMax,
        progressMin: progressMin,
        progress: progress
      });

      return this.createEl('progressbar', this.getProgressbarTmpl(), _objectSpread(_objectSpread({}, defaults), data));
    }
  }, {
    key: "getTitleTmpl",
    value: function getTitleTmpl() {
      return _title.default;
    }
  }, {
    key: "createTitleEl",
    value: function createTitleEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var _this$currentStep$tit = this.currentStep.title,
          title = _this$currentStep$tit === void 0 ? '' : _this$currentStep$tit;
      return this.createEl('title', this.getTitleTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        title: title
      }, data));
    }
  }, {
    key: "getDescriptionTmpl",
    value: function getDescriptionTmpl() {
      return _description.default;
    }
  }, {
    key: "createDescriptionEl",
    value: function createDescriptionEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var _this$currentStep$des = this.currentStep.description,
          description = _this$currentStep$des === void 0 ? '' : _this$currentStep$des;
      return this.createEl('description', this.getDescriptionTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        description: description
      }, data));
    }
  }, {
    key: "getCustomButtonsTmpl",
    value: function getCustomButtonsTmpl() {
      return _customButtons.default;
    }
  }, {
    key: "createCustomButtonsEl",
    value: function createCustomButtonsEl() {
      var _this8 = this;

      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var buttons = [];

      if (this.currentStep.buttons) {
        this.currentStep.buttons.forEach(function (button) {
          var buttonEl = button;

          if (!(0, _isHtmlElement.default)(buttonEl)) {
            var onClick = button.onClick,
                _button$tagName = button.tagName,
                tagName = _button$tagName === void 0 ? 'button' : _button$tagName,
                _button$title = button.title,
                title = _button$title === void 0 ? '' : _button$title,
                className = button.class;
            buttonEl = document.createElement(tagName);
            buttonEl.innerHTML = title;

            if (className) {
              buttonEl.className = className;
            }

            if (onClick) {
              buttonEl.addEventListener('click', function (e) {
                onClick.call(_this8, e);
              });
            }
          }

          buttons.push(buttonEl);
        });
      }

      return this.createEl('customButtons', this.getCustomButtonsTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        buttons: buttons
      }, data));
    }
  }, {
    key: "getPaginationTmpl",
    value: function getPaginationTmpl() {
      return _pagination.default;
    }
  }, {
    key: "createPaginationEl",
    value: function createPaginationEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var _this$currentStep = this.currentStep,
          _this$currentStep$pag = _this$currentStep.paginationTheme,
          paginationTheme = _this$currentStep$pag === void 0 ? this.options.paginationTheme : _this$currentStep$pag,
          _this$currentStep$pag2 = _this$currentStep.paginationCirclesMaxItems,
          paginationCirclesMaxItems = _this$currentStep$pag2 === void 0 ? this.options.paginationCirclesMaxItems : _this$currentStep$pag2;
      var showPagination = this.options.showPagination;

      if (typeof this.currentStep.showPagination === 'boolean') {
        showPagination = this.currentStep.showPagination;
      }

      return this.createEl('pagination', this.getPaginationTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        showPagination: showPagination,
        paginationTheme: paginationTheme,
        paginationCirclesMaxItems: paginationCirclesMaxItems
      }, data));
    }
  }, {
    key: "getPreviousTmpl",
    value: function getPreviousTmpl() {
      return _previous2.default;
    }
  }, {
    key: "createPreviousEl",
    value: function createPreviousEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var showNavigation = this.options.showNavigation;

      if (typeof this.currentStep.showNavigation === 'boolean') {
        showNavigation = this.currentStep.showNavigation;
      }

      return this.createEl('previous', this.getPreviousTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        showNavigation: showNavigation
      }, data));
    }
  }, {
    key: "getNextTmpl",
    value: function getNextTmpl() {
      return _next2.default;
    }
  }, {
    key: "createNextEl",
    value: function createNextEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var showNavigation = this.options.showNavigation;

      if (typeof this.currentStep.showNavigation === 'boolean') {
        showNavigation = this.currentStep.showNavigation;
      }

      return this.createEl('next', this.getNextTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        showNavigation: showNavigation
      }, data));
    }
  }, {
    key: "getCopyrightTmpl",
    value: function getCopyrightTmpl() {
      return _copyright.default;
    }
  }, {
    key: "createCopyrightEl",
    value: function createCopyrightEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.createEl('copyright', this.getCopyrightTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), data));
    }
  }, {
    key: "getNotificationTmpl",
    value: function getNotificationTmpl() {
      return _notification.default;
    }
  }, {
    key: "createNotificationEl",
    value: function createNotificationEl() {
      var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return this.createEl('notification', this.getNotificationTmpl(), _objectSpread(_objectSpread({}, this.getDefaultTmplData()), {}, {
        messages: this.notifications
      }, data));
    }
  }, {
    key: "notify",
    value: function notify(message) {
      this.notifications.push(message);
      var notificationEl = this.getEl('notification');

      if (notificationEl) {
        this.mountEl(this.createNotificationEl(), notificationEl.parentElement);
      }

      return this;
    }
    /**
     * Register an event listener for a tour event.
     *
     * Event names can be comma-separated to register multiple events.
     *
     * @param {string} event The name of the event to listen for.
     * @param {function} listener The event listener, accepts context.
     * @param {object} options Listener options
     * @return {this}
     */

  }, {
    key: "on",
    value: function on(event, listener) {
      var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
      // priorities from low to high
      var priorities = this.constructor.getEventListenersPriorities();

      var _priorities = (0, _slicedToArray2.default)(priorities, 1),
          priority = _priorities[0];

      if (options.priority && priorities.includes(options.priority)) {
        priority = options.priority;
      }

      var e = event.trim();
      this.listeners[e] = this.listeners[e] || {};
      this.listeners[e][priority] = this.listeners[e][priority] || [];
      this.listeners[e][priority].push(listener);
      return this;
    }
    /**
     * Emits an event by name to all registered listeners on that event.
     * Listeners will be called in the order that they were added. If a listener
     * returns `false`, no other listeners will be called.
     *
     * @param {string} event    The name of the event to emit.
     * @param args  The context args of the event, passed to listeners.
     * @returns {Promise}
     */

  }, {
    key: "emit",
    value: function emit(event) {
      var _this9 = this;

      for (var _len6 = arguments.length, args = new Array(_len6 > 1 ? _len6 - 1 : 0), _key6 = 1; _key6 < _len6; _key6++) {
        args[_key6 - 1] = arguments[_key6];
      }

      // from high to low
      var priorities = (0, _toConsumableArray2.default)(this.constructor.getEventListenersPriorities()).reverse();
      var e = event.trim();
      var result = [];
      var promise = Promise.resolve(result);

      if (this.listeners[e]) {
        priorities.forEach(function (priority) {
          var listeners = _this9.listeners[e][priority];

          if (listeners) {
            promise = promise.then(function () {
              return Promise.all(listeners.map(function (f) {
                return Promise.resolve().then(function () {
                  return f.apply(_this9, args);
                });
              }));
            }).then(function (r) {
              result = [].concat((0, _toConsumableArray2.default)(result), (0, _toConsumableArray2.default)(r));
              return result;
            });
          }
        });
      }

      return promise;
    }
    /**
     * Add keydown event listener
     * @return {this}
     */

  }, {
    key: "addOnKeydownListener",
    value: function addOnKeydownListener() {
      // turn on keyboard navigation
      this.cache.set('onKeydownListener', this.getOnKeydownListener());
      window.addEventListener('keydown', this.cache.get('onKeydownListener'), true);
      return this;
    }
    /**
     * Return on key down event listener function
     * @returns {function}
     */

  }, {
    key: "getOnKeydownListener",
    value: function getOnKeydownListener() {
      var _this10 = this;

      return function (event) {
        var keyCode = event.keyCode;

        var _this10$constructor$g = _objectSpread(_objectSpread({}, _this10.constructor.getDefaultKeyboardCodes()), _this10.options.useKeyboard),
            previousCodes = _this10$constructor$g.previous,
            nextCodes = _this10$constructor$g.next,
            stopCodes = _this10$constructor$g.stop; //  stop tour


        if (stopCodes && stopCodes.includes(keyCode)) {
          _this10.stop({
            event: event
          });

          return;
        } // go to the previous step


        if (previousCodes && previousCodes.includes(keyCode)) {
          _this10.previous({
            event: event
          });

          return;
        } // go to the next step


        if (nextCodes && nextCodes.includes(keyCode)) {
          _this10.next({
            event: event
          });
        }
      };
    }
    /**
     * Remove keydown event listener
     * @return {this}
     */

  }, {
    key: "removeOnKeydownListener",
    value: function removeOnKeydownListener() {
      if (this.cache.has('onKeydownListener')) {
        window.removeEventListener('keydown', this.cache.get('onKeydownListener'), true);
        this.cache.delete('onKeydownListener');
      }

      return this;
    }
    /**
     * Add window resize event listener
     * @return {this}
     */

  }, {
    key: "addOnWindowResizeListener",
    value: function addOnWindowResizeListener() {
      // turn on keyboard navigation
      this.cache.set('onWindowResizeListener', this.getOnWindowResizeListener());
      window.addEventListener('resize', this.cache.get('onWindowResizeListener'), true);
      return this;
    }
    /**
     * Return on window resize event listener function
     * @returns {function}
     */

  }, {
    key: "getOnWindowResizeListener",
    value: function getOnWindowResizeListener() {
      var _this11 = this;

      return function () {
        return _this11.refresh();
      };
    }
    /**
     * Remove window resize event listener
     * @return {this}
     */

  }, {
    key: "removeOnWindowResizeListener",
    value: function removeOnWindowResizeListener() {
      if (this.cache.has('onWindowResizeListener')) {
        window.removeEventListener('resize', this.cache.get('onWindowResizeListener'), true);
        this.cache.delete('onWindowResizeListener');
      }

      return this;
    }
    /**
     * Add window scroll event listener
     * @returns {GuideChimp}
     */

  }, {
    key: "addOnWindowScrollListener",
    value: function addOnWindowScrollListener() {
      this.cache.set('onWindowScrollListener', this.getOnWindowScrollListener());
      window.addEventListener('scroll', this.cache.get('onWindowScrollListener'), true);
      return this;
    }
    /**
     * Return on window scroll event listener function
     * @returns {function}
     */

  }, {
    key: "getOnWindowScrollListener",
    value: function getOnWindowScrollListener() {
      var _this12 = this;

      return function () {
        return _this12.refresh();
      };
    }
    /**
     * Remove window resize event listener
     * @return {this}
     */

  }, {
    key: "removeOnWindowScrollListener",
    value: function removeOnWindowScrollListener() {
      if (this.cache.has('onWindowScrollListener')) {
        window.removeEventListener('scroll', this.cache.get('onWindowScrollListener'), true);
        this.cache.delete('onWindowScrollListener');
      }

      return this;
    }
  }, {
    key: "removeListeners",
    value: function removeListeners() {
      this.removeOnKeydownListener();
      this.removeOnWindowResizeListener();
      this.removeOnWindowScrollListener();
    }
  }, {
    key: "observeStep",
    value: function observeStep() {
      this.observeResizing();
      this.observeMutation();
    }
  }, {
    key: "observeResizing",
    value: function observeResizing() {
      var _this13 = this;

      var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
        box: 'border-box'
      };
      var observer = this.observers.resizingObserver;

      if (!observer && typeof ResizeObserver !== 'undefined') {
        observer = new ResizeObserver(function () {
          if (!_this13 && !_this13.currentStep) {
            return;
          }

          _this13.refresh();
        });
        this.observers.resizingObserver = observer;
      }

      if (observer) {
        // observe elements
        observer.observe(this.getStepEl(this.currentStep), options);
        return true;
      }

      return false;
    }
  }, {
    key: "unobserveResizing",
    value: function unobserveResizing() {
      var observer = this.observers.resizingObserver;

      if (observer) {
        observer.disconnect();
        return true;
      }

      return false;
    }
  }, {
    key: "observeMutation",
    value: function observeMutation() {
      var _this14 = this;

      var observer = this.observers.mutationObserver;

      if (!observer) {
        observer = new MutationObserver(function (mutations) {
          if (!_this14 && !_this14.currentStep) {
            return;
          }

          var element = _this14.currentStep.element;

          if (!element) {
            return;
          }

          var el = _this14.getStepEl(_this14.currentStep);

          var isElExists = function isElExists() {
            return el && !_this14.isEl(el, 'fakeStep');
          };

          mutations.forEach(function (record) {
            if (isElExists()) {
              if (record.type === 'childList' && record.removedNodes.length) {
                record.removedNodes.forEach(function (node) {
                  if (node === el || node.contains(el)) {
                    el = _this14.getStepEl(_this14.currentStep);

                    _this14.scrollParentsToStepEl();

                    _this14.refresh();
                  }
                });
              }
            } else if (record.type === 'childList' && record.addedNodes.length) {
              el = _this14.getStepEl(_this14.currentStep);

              if (isElExists()) {
                _this14.scrollParentsToStepEl();

                _this14.refresh();
              }
            }
          });
        });
        this.observers.mutationObserver = observer;
      }

      observer.observe(this.getStepEl(this.currentStep).ownerDocument.body, {
        childList: true,
        subtree: true
      });
      return true;
    }
  }, {
    key: "unobserveMutation",
    value: function unobserveMutation() {
      var observer = this.observers.mutationObserver;

      if (observer) {
        observer.disconnect();
        return true;
      }

      return false;
    }
  }, {
    key: "unobserveStep",
    value: function unobserveStep() {
      this.unobserveResizing();
      this.unobserveMutation();
    }
  }, {
    key: "beforeChangeStep",
    value: function beforeChangeStep() {
      this.unmountStep();
      this.unobserveStep();
    }
    /**
     * Refresh layers position
     * @returns {this}
     */

  }, {
    key: "refresh",
    value: function refresh() {
      if (!this.currentStep) {
        return this;
      }

      this.highlightStepEl();
      this.setControlPosition(this.getEl('control'));
      this.setInteractionPosition(this.getEl('interaction'));
      this.setTooltipPosition(this.getEl('tooltip'));
      return this;
    }
  }], [{
    key: "getDefaultOptions",
    value: function getDefaultOptions() {
      return {
        position: 'bottom',
        useKeyboard: true,
        exitEscape: true,
        exitOverlay: true,
        showPagination: true,
        showNavigation: true,
        showProgressbar: true,
        paginationTheme: 'circles',
        paginationCirclesMaxItems: 10,
        interaction: true,
        padding: 8,
        scrollPadding: 10,
        scrollBehavior: 'auto'
      };
    }
  }, {
    key: "getDefaultKeyboardCodes",
    value: function getDefaultKeyboardCodes() {
      var escCode = 27;
      var arrowLeftCode = 37;
      var arrowRightCode = 39;
      var enterCode = 13;
      var spaceCode = 32;
      return {
        previous: [arrowLeftCode],
        next: [arrowRightCode, enterCode, spaceCode],
        stop: [escCode]
      };
    }
  }, {
    key: "getEventListenersPriorities",
    value: function getEventListenersPriorities() {
      return ['low', 'medium', 'high', 'critical'];
    }
  }, {
    key: "getBodyClass",
    value: function getBodyClass() {
      return 'gc';
    }
  }, {
    key: "getLoadingClass",
    value: function getLoadingClass() {
      return 'gc-loading';
    }
  }, {
    key: "getHighlightClass",
    value: function getHighlightClass() {
      return 'gc-highlight';
    }
  }, {
    key: "getFixedClass",
    value: function getFixedClass() {
      return 'gc-fixed';
    }
  }, {
    key: "getRelativePositionClass",
    value: function getRelativePositionClass() {
      return 'gc-relative';
    }
    /**
     * Get element offset
     * @param el
     * @return {{top: number, left: number, width: number, height: number}}
     */

  }, {
    key: "getOffset",
    value: function getOffset(el) {
      var _el$ownerDocument = el.ownerDocument,
          body = _el$ownerDocument.body,
          documentElement = _el$ownerDocument.documentElement,
          view = _el$ownerDocument.defaultView;
      var scrollTop = view.pageYOffset || documentElement.scrollTop || body.scrollTop;
      var scrollLeft = view.pageXOffset || documentElement.scrollLeft || body.scrollLeft;

      var _el$getBoundingClient4 = el.getBoundingClientRect(),
          top = _el$getBoundingClient4.top,
          right = _el$getBoundingClient4.right,
          bottom = _el$getBoundingClient4.bottom,
          left = _el$getBoundingClient4.left,
          width = _el$getBoundingClient4.width,
          height = _el$getBoundingClient4.height,
          x = _el$getBoundingClient4.x,
          y = _el$getBoundingClient4.y;

      return {
        right: right,
        bottom: bottom,
        width: width,
        height: height,
        x: x,
        y: y,
        top: top + scrollTop,
        left: left + scrollLeft
      };
    }
    /**
     * Check if el or his parent has fixed position
     * @param el
     * @return {boolean}
     */

  }, {
    key: "isFixed",
    value: function isFixed(el) {
      var parentNode = el.parentNode;

      if (!parentNode || parentNode.nodeName === 'HTML') {
        return false;
      }

      var elStyle = getComputedStyle(el);

      if (elStyle.getPropertyValue('position') === 'fixed') {
        return true;
      }

      return this.isFixed(parentNode);
    }
  }]);
  return GuideChimp;
}();

exports["default"] = GuideChimp;

/***/ }),

/***/ 2157:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

"use strict";


var _interopRequireDefault = __webpack_require__(5318);

var _construct2 = _interopRequireDefault(__webpack_require__(9100));

var _GuideChimp = _interopRequireDefault(__webpack_require__(2608));

__webpack_require__(8547);

/**
 * Copyright (C) 2020 Labs64 GmbH
 *
 * This source code is licensed under the European Union Public License, version 1.2
 * located in the LICENSE file
 */

/* ============
 * Styling
 * ============
 *
 * Import the library styling.
 */
var guideChimp = function guideChimp() {
  for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
    args[_key] = arguments[_key];
  }

  return (0, _construct2.default)(_GuideChimp.default, args);
};

guideChimp.prototype = _GuideChimp.default.prototype;
guideChimp.plugins = new Set();

guideChimp.extend = function (plugin) {
  if (!guideChimp.plugins.has(plugin)) {
    guideChimp.plugins.add(plugin);

    for (var _len2 = arguments.length, args = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
      args[_key2 - 1] = arguments[_key2];
    }

    plugin.apply(void 0, [_GuideChimp.default, guideChimp].concat(args));
  }

  return guideChimp;
};

module.exports = guideChimp;

/***/ }),

/***/ 7726:
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";


var _interopRequireDefault = __webpack_require__(5318);

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

var _defineProperty2 = _interopRequireDefault(__webpack_require__(9713));

var _slicedToArray2 = _interopRequireDefault(__webpack_require__(3038));

var _construct2 = _interopRequireDefault(__webpack_require__(9100));

var _toConsumableArray2 = _interopRequireDefault(__webpack_require__(319));

var _isUndefined2 = _interopRequireDefault(__webpack_require__(2353));

var _isNull2 = _interopRequireDefault(__webpack_require__(5220));

var _isHtmlElement = _interopRequireDefault(__webpack_require__(854));

var _isSvgElement = _interopRequireDefault(__webpack_require__(7179));

var _isNodeList = _interopRequireDefault(__webpack_require__(8603));

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { (0, _defineProperty2.default)(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

var _default = function _default(tpl) {
  var data = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  var parser = new DOMParser();
  var template = tpl.replace(/<template/g, '<gc-template');
  template = template.replace(/<\/template/g, '</gc-template');
  var sourceDoc = parser.parseFromString(template, 'text/html');
  var renderedDoc = document.implementation.createHTMLDocument();
  var pattern = /{{([^}}]+)?}}/gm;
  var eventPattern = /^@(.+)$/;
  var ifEnded = new Map();

  var render = function render(node) {
    var replacements = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var parent = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : renderedDoc.body;
    var handler = parent;
    var keys = Object.keys(replacements);
    var values = Object.values(replacements); // eslint-disable-next-line no-new-func

    var getValue = function getValue(key) {
      return (0, _construct2.default)(Function, (0, _toConsumableArray2.default)(keys).concat(["return ".concat(key, ";")])).apply(void 0, (0, _toConsumableArray2.default)(values));
    };

    if (node) {
      if (node.nodeType === Node.ELEMENT_NODE) {
        if (node.hasAttribute('if')) {
          ifEnded.set(node.parentNode, false);

          if (!getValue(node.getAttribute('if'))) {
            return;
          }

          ifEnded.set(node.parentNode, true);
        }

        if (node.hasAttribute('elseif')) {
          if (ifEnded.get(node.parentNode) || !getValue(node.getAttribute('elseif'))) {
            return;
          }

          ifEnded.set(node.parentNode, true);
        }

        if (node.hasAttribute('else')) {
          if (ifEnded.get(node.parentNode)) {
            return;
          }

          ifEnded.set(node.parentNode, true);
        }

        if (node.hasAttribute('for')) {
          var forPieces = node.getAttribute('for').split(' in ');

          var _forPieces = (0, _slicedToArray2.default)(forPieces, 2),
              firstPiece = _forPieces[0],
              secondPiece = _forPieces[1];

          node.removeAttribute('for');

          var _firstPiece$replace$s = firstPiece.replace(/\(|\)/g, '').split(','),
              _firstPiece$replace$s2 = (0, _slicedToArray2.default)(_firstPiece$replace$s, 2),
              param = _firstPiece$replace$s2[0],
              index = _firstPiece$replace$s2[1];

          param = param.trim();
          index = index ? index.trim() : '';
          var source = getValue(secondPiece.trim());
          var isSourceArray = Array.isArray(source);
          Object.keys(source).forEach(function (k) {
            var r = _objectSpread(_objectSpread({}, replacements), {}, (0, _defineProperty2.default)({}, param, source[k]));

            if (index) {
              r[index] = isSourceArray ? parseInt(k, 10) : k;
            }

            render(node, r, handler);
          });
          return;
        }

        if (node !== node.ownerDocument.body && node.tagName !== 'GC-TEMPLATE') {
          handler = node.cloneNode();
          parent.append(handler);
        }

        (0, _toConsumableArray2.default)(node.attributes).forEach(function (attr) {
          var name = attr.name,
              value = attr.value;
          var eventMatch = eventPattern.exec(name);

          if (eventMatch) {
            var _eventMatch = (0, _slicedToArray2.default)(eventMatch, 2),
                eventName = _eventMatch[1]; // eslint-disable-next-line no-new-func


            handler.addEventListener(eventName, function (e) {
              return (0, _construct2.default)(Function, [].concat((0, _toConsumableArray2.default)(keys), ['$event']).concat(["return ".concat(value).concat(/\(.+\)/.test(value) ? '' : '()', ";")])).apply(void 0, [].concat((0, _toConsumableArray2.default)(values), [e]));
            });
            handler.removeAttribute(name);
            return;
          }

          var match = pattern.exec(value);
          var index = 0;
          var rValue = '';

          while (match) {
            rValue += value.slice(index, match.index);

            var _match = match,
                _match2 = (0, _slicedToArray2.default)(_match, 2),
                replacement = _match2[0],
                key = _match2[1];

            key = key.trim();

            try {
              replacement = getValue(key);

              if ((0, _isUndefined2.default)(replacement) || (0, _isNull2.default)(replacement)) {
                replacement = '';
              }
            } catch (e) {
              // eslint-disable-next-line no-console
              console.error(e);
            }

            rValue += replacement;
            index = match.index + match[0].length;
            match = pattern.exec(value);
          }

          rValue += value.substr(index, value.length - index);

          if (name === 'html') {
            handler.innerHTML = rValue;
            handler.removeAttribute(name);
          } else if (['if', 'else', 'elseif'].includes(name)) {
            handler.removeAttribute(name);
          } else {
            handler.setAttribute(name, rValue);
          }
        });
      } else if (node.nodeType === Node.TEXT_NODE) {
        var match = pattern.exec(node.nodeValue);

        if (match) {
          var _index = 0;

          while (match) {
            handler.append(document.createTextNode(node.nodeValue.slice(_index, match.index)));

            var _match3 = match,
                _match4 = (0, _slicedToArray2.default)(_match3, 2),
                replacement = _match4[0],
                key = _match4[1];

            key = key.trim();

            try {
              replacement = getValue(key);

              if ((0, _isUndefined2.default)(replacement) || (0, _isNull2.default)(replacement)) {
                replacement = '';
              }
            } catch (e) {
              // eslint-disable-next-line no-console
              console.error(e);
            }

            if ((0, _isHtmlElement.default)(replacement) || (0, _isSvgElement.default)(replacement)) {
              handler.append(replacement);
            } else if ((0, _isNodeList.default)(replacement)) {
              replacement.forEach(function (v) {
                handler.append(v);
              });
            } else {
              handler.append(document.createTextNode(replacement));
            }

            _index = match.index + match[0].length;
            match = pattern.exec(node.nodeValue);
          }

          handler.append(document.createTextNode(node.nodeValue.slice(_index, node.nodeValue.length)));
        } else {
          handler.append(node.cloneNode());
        }
      }

      var _node$childNodes = node.childNodes,
          childNodes = _node$childNodes === void 0 ? [] : _node$childNodes;

      if (childNodes.length) {
        childNodes.forEach(function (v) {
          render(v, replacements, handler);
        });
      }
    }
  };

  render(sourceDoc.body, data, renderedDoc.body);
  return renderedDoc.body.firstElementChild;
};

exports["default"] = _default;

/***/ }),

/***/ 854:
/***/ (function(__unused_webpack_module, exports) {

"use strict";


Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

var _default = function _default(el) {
  return el instanceof HTMLElement || /^\[object HTML(.+)Element\]$/.test("".concat(el));
};

exports["default"] = _default;

/***/ }),

/***/ 8603:
/***/ (function(__unused_webpack_module, exports) {

"use strict";


Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

var _default = function _default(el) {
  return /^[object NodeList]$/.test("".concat(el));
};

exports["default"] = _default;

/***/ }),

/***/ 7179:
/***/ (function(__unused_webpack_module, exports) {

"use strict";


Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

var _default = function _default(el) {
  return el instanceof SVGElement || /^\[object SVG(.+)Element\]$/.test("".concat(el));
};

exports["default"] = _default;

/***/ }),

/***/ 3636:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div class=\"gc-close\" @click=\"stop({ event: $event })\"></div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 1298:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div class=\"gc-control\"> {{ tooltipEl }} </div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 3251:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div class=\"gc-copyright\">Made with GuideChimp</div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 7185:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div if=\"buttons.length\" class=\"gc-custom-buttons\"> <template for=\"button in buttons\"> {{ button }} </template> </div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 4127:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div if=\"description\" html=\"{{ description }}\" class=\"gc-description\"></div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 7159:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div class=\"gc-fake-step\"></div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 4462:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div if=\"!interaction\" class=\"gc-interaction gc-disable\"> </div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 8511:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div class=\"gc-navigation-next {{ (!nextStep || !showNavigation) ? 'gc-hidden': '' }}\" @click=\"next({ event: $event })\"></div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 2127:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div html=\"{{ messages[0] }}\" class=\"gc-notification\"></div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 8945:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div class=\"gc-overlay\" @click=\"stop({ event: $event })\"> <svg class=\"svg-overlay\"> <path d=\"{{path}}\"> <animate attributeName=\"d\" dur=\"200ms\"/> </path> </svg> </div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 2994:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div if=\"showPagination && steps.length > 1\" class=\"gc-pagination\"> <template if=\"paginationTheme === 'numbers' || steps.length >= paginationCirclesMaxItems\"> <ul class=\"gc-pagination-theme-numbers\"> <template for=\"(step, index) in steps\"> <template if=\"index === 0\"> <li if=\"index === currentStepIndex\" class=\"gc-pagination-item gc-pagination-item-current gc-pagination-active\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === previousStepIndex\" class=\"gc-pagination-item gc-pagination-item-previous\" @click=\"previous({ event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === nextStepIndex\" class=\"gc-pagination-item gc-pagination-item-next\" @click=\"next({ event: $event })\"> {{ index + 1 }} </li> <li else class=\"gc-pagination-item\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> </template> <template if=\"currentStepIndex < 3\"> <template if=\"index > 0 && index < 5\"> <li if=\"index === currentStepIndex\" class=\"gc-pagination-item gc-pagination-item-current gc-pagination-active\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === previousStepIndex\" class=\"gc-pagination-item gc-pagination-item-previous\" @click=\"previous({ event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === nextStepIndex\" class=\"gc-pagination-item gc-pagination-item-next\" @click=\"next({ event: $event })\"> {{ index + 1 }} </li> <li else class=\"gc-pagination-item\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> </template> <li elseif=\"index === 5 && index !== steps.length - 1\" class=\"gc-pagination-dots\"> ... </li> </template> <template elseif=\"steps.length - currentStepIndex < 5\"> <template if=\"steps.length - index < 6 && steps.length - 1 !== index\"> <li if=\"index === currentStepIndex\" class=\"gc-pagination-item gc-pagination-item-current gc-pagination-active\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === previousStepIndex\" class=\"gc-pagination-item gc-pagination-item-previous\" @click=\"previous({ event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === nextStepIndex\" class=\"gc-pagination-item gc-pagination-item-next\" @click=\"next({ event: $event })\"> {{ index + 1 }} </li> <li else class=\"gc-pagination-item\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> </template> <li elseif=\"steps.length - index === 6 && index !== 0\" class=\"gc-pagination-dots\"> ... </li> </template> <template else> <li if=\"currentStepIndex - index === 3 && index !== 0\" class=\"gc-pagination-dots\"> ... </li> <template elseif=\"(currentStepIndex - index >= 0 && currentStepIndex - index < 3)\n                    || ( index - currentStepIndex >= 0 && index - currentStepIndex < 3)\"> <li if=\"index === currentStepIndex\" class=\"gc-pagination-item gc-pagination-item-current gc-pagination-active\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === previousStepIndex\" class=\"gc-pagination-item gc-pagination-item-previous\" @click=\"previous({ event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === nextStepIndex\" class=\"gc-pagination-item gc-pagination-item-next\" @click=\"next({ event: $event })\"> {{ index + 1 }} </li> <li else class=\"gc-pagination-item\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> </template> <li elseif=\"index - currentStepIndex === 3 && steps.length -1 !== index\" class=\"gc-pagination-dots\"> ... </li> </template> <template if=\"index + 1 === steps.length\"> <li if=\"index === currentStepIndex\" class=\"gc-pagination-item gc-pagination-item-current gc-pagination-active\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === previousStepIndex\" class=\"gc-pagination-item gc-pagination-item-previous\" @click=\"previous({ event: $event })\"> {{ index + 1 }} </li> <li elseif=\"index === nextStepIndex\" class=\"gc-pagination-item gc-pagination-item-next\" @click=\"next({ event: $event })\"> {{ index + 1 }} </li> <li else class=\"gc-pagination-item\" @click=\"go(index, true, { event: $event })\"> {{ index + 1 }} </li> </template> </template> </ul> </template> <template else> <div class=\"gc-pagination-theme-circles\"> <template for=\"(step, index) in steps\"> <div if=\"index === currentStepIndex\" class=\"gc-pagination-item gc-pagination-item-current gc-pagination-active\"></div> <div elseif=\"index === previousStepIndex\" class=\"gc-pagination-item gc-pagination-item-previous\" @click=\"previous({ event: $event })\"></div> <div elseif=\"index === nextStepIndex\" class=\"gc-pagination-item gc-pagination-item-next\" @click=\"next({ event: $event })\"></div> <div else class=\"gc-pagination-item\" @click=\"go(index, true, { event: $event })\"></div> </template> </div> </template> </div> ";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 9357:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div class=\"gc-preloader\"></div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 1439:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div class=\"gc-navigation-prev {{ (!previousStep || !showNavigation) ? 'gc-hidden': '' }}\" @click=\"previous({ event: $event })\"></div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 7705:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div if=\"showProgressbar\" class=\"gc-progressbar\" role=\"progressbar\" aria-valuemin=\"{{ progressMin }}\" aria-valuemax=\"{{ progressMax }}\" aria-valuenow=\"{{ progress }}\" style=\"width:{{ progress }}%;\"></div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 2844:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div if=\"title\" html=\"{{ title }}\" class=\"gc-title\"> </div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 9176:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// Module
var code = "<div class=\"gc-tooltip\"> <div class=\"gc-tooltip-tail\"></div> {{ progressbar }} {{ title }} {{ description }} {{ close }} {{ customButtons }} <div if=\"previous || pagination || next\" class=\"gc-navigation\"> {{ previous }} {{ pagination }} {{ next }} </div> {{ copyright }} {{ notification }} </div>";
// Exports
/* harmony default export */ __webpack_exports__["default"] = (code);

/***/ }),

/***/ 2705:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var root = __webpack_require__(5639);

/** Built-in value references. */
var Symbol = root.Symbol;

module.exports = Symbol;


/***/ }),

/***/ 9932:
/***/ (function(module) {

/**
 * A specialized version of `_.map` for arrays without support for iteratee
 * shorthands.
 *
 * @private
 * @param {Array} [array] The array to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Array} Returns the new mapped array.
 */
function arrayMap(array, iteratee) {
  var index = -1,
      length = array == null ? 0 : array.length,
      result = Array(length);

  while (++index < length) {
    result[index] = iteratee(array[index], index, array);
  }
  return result;
}

module.exports = arrayMap;


/***/ }),

/***/ 4239:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var Symbol = __webpack_require__(2705),
    getRawTag = __webpack_require__(9607),
    objectToString = __webpack_require__(2333);

/** `Object#toString` result references. */
var nullTag = '[object Null]',
    undefinedTag = '[object Undefined]';

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * The base implementation of `getTag` without fallbacks for buggy environments.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the `toStringTag`.
 */
function baseGetTag(value) {
  if (value == null) {
    return value === undefined ? undefinedTag : nullTag;
  }
  return (symToStringTag && symToStringTag in Object(value))
    ? getRawTag(value)
    : objectToString(value);
}

module.exports = baseGetTag;


/***/ }),

/***/ 531:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var Symbol = __webpack_require__(2705),
    arrayMap = __webpack_require__(9932),
    isArray = __webpack_require__(1469),
    isSymbol = __webpack_require__(3448);

/** Used as references for various `Number` constants. */
var INFINITY = 1 / 0;

/** Used to convert symbols to primitives and strings. */
var symbolProto = Symbol ? Symbol.prototype : undefined,
    symbolToString = symbolProto ? symbolProto.toString : undefined;

/**
 * The base implementation of `_.toString` which doesn't convert nullish
 * values to empty strings.
 *
 * @private
 * @param {*} value The value to process.
 * @returns {string} Returns the string.
 */
function baseToString(value) {
  // Exit early for strings to avoid a performance hit in some environments.
  if (typeof value == 'string') {
    return value;
  }
  if (isArray(value)) {
    // Recursively convert values (susceptible to call stack limits).
    return arrayMap(value, baseToString) + '';
  }
  if (isSymbol(value)) {
    return symbolToString ? symbolToString.call(value) : '';
  }
  var result = (value + '');
  return (result == '0' && (1 / value) == -INFINITY) ? '-0' : result;
}

module.exports = baseToString;


/***/ }),

/***/ 1957:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

/** Detect free variable `global` from Node.js. */
var freeGlobal = typeof __webpack_require__.g == 'object' && __webpack_require__.g && __webpack_require__.g.Object === Object && __webpack_require__.g;

module.exports = freeGlobal;


/***/ }),

/***/ 9607:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var Symbol = __webpack_require__(2705);

/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * A specialized version of `baseGetTag` which ignores `Symbol.toStringTag` values.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the raw `toStringTag`.
 */
function getRawTag(value) {
  var isOwn = hasOwnProperty.call(value, symToStringTag),
      tag = value[symToStringTag];

  try {
    value[symToStringTag] = undefined;
    var unmasked = true;
  } catch (e) {}

  var result = nativeObjectToString.call(value);
  if (unmasked) {
    if (isOwn) {
      value[symToStringTag] = tag;
    } else {
      delete value[symToStringTag];
    }
  }
  return result;
}

module.exports = getRawTag;


/***/ }),

/***/ 2333:
/***/ (function(module) {

/** Used for built-in method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/**
 * Converts `value` to a string using `Object.prototype.toString`.
 *
 * @private
 * @param {*} value The value to convert.
 * @returns {string} Returns the converted string.
 */
function objectToString(value) {
  return nativeObjectToString.call(value);
}

module.exports = objectToString;


/***/ }),

/***/ 5639:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var freeGlobal = __webpack_require__(1957);

/** Detect free variable `self`. */
var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

/** Used as a reference to the global object. */
var root = freeGlobal || freeSelf || Function('return this')();

module.exports = root;


/***/ }),

/***/ 1469:
/***/ (function(module) {

/**
 * Checks if `value` is classified as an `Array` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an array, else `false`.
 * @example
 *
 * _.isArray([1, 2, 3]);
 * // => true
 *
 * _.isArray(document.body.children);
 * // => false
 *
 * _.isArray('abc');
 * // => false
 *
 * _.isArray(_.noop);
 * // => false
 */
var isArray = Array.isArray;

module.exports = isArray;


/***/ }),

/***/ 5220:
/***/ (function(module) {

/**
 * Checks if `value` is `null`.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is `null`, else `false`.
 * @example
 *
 * _.isNull(null);
 * // => true
 *
 * _.isNull(void 0);
 * // => false
 */
function isNull(value) {
  return value === null;
}

module.exports = isNull;


/***/ }),

/***/ 7005:
/***/ (function(module) {

/**
 * Checks if `value` is object-like. A value is object-like if it's not `null`
 * and has a `typeof` result of "object".
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
 * @example
 *
 * _.isObjectLike({});
 * // => true
 *
 * _.isObjectLike([1, 2, 3]);
 * // => true
 *
 * _.isObjectLike(_.noop);
 * // => false
 *
 * _.isObjectLike(null);
 * // => false
 */
function isObjectLike(value) {
  return value != null && typeof value == 'object';
}

module.exports = isObjectLike;


/***/ }),

/***/ 3448:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var baseGetTag = __webpack_require__(4239),
    isObjectLike = __webpack_require__(7005);

/** `Object#toString` result references. */
var symbolTag = '[object Symbol]';

/**
 * Checks if `value` is classified as a `Symbol` primitive or object.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a symbol, else `false`.
 * @example
 *
 * _.isSymbol(Symbol.iterator);
 * // => true
 *
 * _.isSymbol('abc');
 * // => false
 */
function isSymbol(value) {
  return typeof value == 'symbol' ||
    (isObjectLike(value) && baseGetTag(value) == symbolTag);
}

module.exports = isSymbol;


/***/ }),

/***/ 2353:
/***/ (function(module) {

/**
 * Checks if `value` is `undefined`.
 *
 * @static
 * @since 0.1.0
 * @memberOf _
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is `undefined`, else `false`.
 * @example
 *
 * _.isUndefined(void 0);
 * // => true
 *
 * _.isUndefined(null);
 * // => false
 */
function isUndefined(value) {
  return value === undefined;
}

module.exports = isUndefined;


/***/ }),

/***/ 9833:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var baseToString = __webpack_require__(531);

/**
 * Converts `value` to a string. An empty string is returned for `null`
 * and `undefined` values. The sign of `-0` is preserved.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to convert.
 * @returns {string} Returns the converted string.
 * @example
 *
 * _.toString(null);
 * // => ''
 *
 * _.toString(-0);
 * // => '-0'
 *
 * _.toString([1, 2, 3]);
 * // => '1,2,3'
 */
function toString(value) {
  return value == null ? '' : baseToString(value);
}

module.exports = toString;


/***/ }),

/***/ 3955:
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var toString = __webpack_require__(9833);

/** Used to generate unique IDs. */
var idCounter = 0;

/**
 * Generates a unique ID. If `prefix` is given, the ID is appended to it.
 *
 * @static
 * @since 0.1.0
 * @memberOf _
 * @category Util
 * @param {string} [prefix=''] The value to prefix the ID with.
 * @returns {string} Returns the unique ID.
 * @example
 *
 * _.uniqueId('contact_');
 * // => 'contact_104'
 *
 * _.uniqueId();
 * // => '105'
 */
function uniqueId(prefix) {
  var id = ++idCounter;
  return toString(prefix) + id;
}

module.exports = uniqueId;


/***/ }),

/***/ 8547:
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/global */
/******/ 	!function() {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	var __webpack_exports__ = __webpack_require__(2157);
/******/ 	
/******/ 	return __webpack_exports__;
/******/ })()
;
});
//# sourceMappingURL=guidechimp.js.map