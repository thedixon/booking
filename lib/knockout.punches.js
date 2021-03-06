﻿/*
 Knockout.Punches
 Enhanced binding syntaxes for Knockout 3+
 (c) Michael Best
 License: MIT (http://www.opensource.org/licenses/mit-license.php)
 Version 0.3.0
*/
(function (d) { "function" === typeof define && define.amd ? define(["knockout"], d) : d(ko) })(function (d) {
    function k(a, b) { return q(x(a), "preprocess", b) } function x(a) { return "object" === typeof a ? a : d.getBindingHandler(a) || (d.bindingHandlers[a] = {}) } function q(a, b, c) { if (a[b]) { var e = a[b]; a[b] = function (a, b, d) { if (a = e.call(this, a, b, d)) return c.call(this, a, b, d) } } else a[b] = c; return a } function r(a) {
        var b = d.bindingProvider.instance; if (b.preprocessNode) {
            var c = b.preprocessNode; b.preprocessNode = function (b) {
                var f = c.call(this,
                b); f || (f = a.call(this, b)); return f
            }
        } else b.preprocessNode = a
    } function y(a, b) { var c = d.getBindingHandler; d.getBindingHandler = function (e) { var f; return c(e) || (f = e.match(a)) && b(f, e) } } function s(a) {
        if (-1 === a.indexOf("|")) return a; var b = a.match(/"([^"\\]|\\.)*"|'([^'\\]|\\.)*'|\|\||[|:]|[^\s|:"'][^|:"']*[^\s|:"']|[^\s|:"']/g); if (b && 1 < b.length) {
            b.push("|"); a = b[0]; for (var c, e, f = !1, d = !1, h = 1; e = b[h]; ++h) "|" === e ? (f && (":" === c && (a += "undefined"), a += ")"), f = d = !0) : (d ? a = "ko.filters['" + e + "'](" + a : f && ":" === e ? (":" === c && (a +=
            "undefined"), a += ",") : a += e, d = !1), c = e
        } return a
    } function z(a) { k(a, s) } function t(a, b, c) { function e(c) { f[c] && (f[c] = function (e, f) { var g = Array.prototype.slice.call(arguments, 0); g[1] = function () { var b = {}; b[a] = f(); return b }; return d.bindingHandlers[b][c].apply(this, g) }) } var f = d.utils.extend({}, this); e("init"); e("update"); f.preprocess && (f.preprocess = null); d.virtualElements.allowedBindings[b] && (d.virtualElements.allowedBindings[c] = !0); return f } function u(a, b) {
        var c = d.getBindingHandler(a); if (c) {
            var e = c.getNamespacedHandler ||
            t; c.getNamespacedHandler = function () { return k(e.apply(this, arguments), b) }
        }
    } function A(a, b, c) { if ("{" !== a.charAt(0)) return a; a = d.expressionRewriting.parseObjectLiteral(a); d.utils.arrayForEach(a, function (a) { c(b + B + a.key, a.value) }) } function m(a) { k(a, A) } function l(a) { return /^([$_a-z][$\w]*|.+(\.\s*[$_a-z][$\w]*|\[.+\]))$/i.test(a) ? "function(_x,_y,_z){return(" + a + ")(_x,_y,_z);}" : a } function n(a) { k(a, l) } function p(a, b, c) {
        a = x(a); a._propertyPreprocessors || (q(a, "preprocess", H), a._propertyPreprocessors = {}); q(a._propertyPreprocessors,
        b, c)
    } function H(a, b, c) { if ("{" !== a.charAt(0)) return a; a = d.expressionRewriting.parseObjectLiteral(a); var e = [], f = this._propertyPreprocessors || {}; d.utils.arrayForEach(a, function (a) { var b = a.key; a = a.value; f[b] && (a = f[b](a, b, c)); a && e.push("'" + b + "':" + a) }); return "{" + e.join(",") + "}" } function v(a) { return function (b) { return "function(" + a + "){return(" + b + ");}" } } function C(a, b, c) {
        function e(a) {
            var d = a.match(/^([\s\S]*?)\{\{([\s\S]*)}}([\s\S]*)$/); if (d) {
                b(d[1]); a = d[2]; var h = a.match(/^([\s\S]*?)}}([\s\S]*)\{\{([\s\S]*)$/);
                h ? (c(h[1]), e(h[2]), c(h[3])) : c(a); b(d[3])
            } else b(a)
        } e(a)
    } function D(a) { if (3 === a.nodeType && a.nodeValue && -1 !== a.nodeValue.indexOf("{{")) { var b = []; C(a.nodeValue, function (a) { a && b.push(document.createTextNode(a)) }, function (a) { a && b.push.apply(b, I.wrapExpresssion(a)) }); if (1 < b.length) { if (a.parentNode) { for (var c = 0; c < b.length; c++) a.parentNode.insertBefore(b[c], a); a.parentNode.removeChild(a) } return b } } } function E() { r(D) } function F(a) {
        if (1 === a.nodeType && a.attributes.length) for (var b = a.getAttribute(w), c = a.attributes,
        e = c.length - 1; 0 <= e; --e) { var d = c[e]; if (d.specified && d.name != w && -1 !== d.value.indexOf("{{")) { var g = [], h = 0; C(d.value, function (a) { a && g.push('"' + a.replace(/"/g, '\\"') + '"') }, function (a) { a && (h = a, g.push("ko.unwrap(" + a + ")")) }); 1 < g.length && (h = '""+' + g.join("+")); h && (h = "attr." + d.name + ":" + h, b = b ? b + ("," + h) : h, a.setAttribute(w, b), a.removeAttributeNode(d)) } }
    } var g = d.punches = { utils: { setBindingPreprocessor: k, setNodePreprocessor: r, setBindingHandlerCreator: y } }; g.enableAll = function () {
        E(); m("attr"); m("css"); m("event"); m("style");
        z("text"); u("attr", s); n("click"); n("submit"); n("optionsAfterRender"); u("event", l); p("template", "beforeRemove", l); p("template", "afterAdd", l); p("template", "afterRender", l)
    }; d.filters = {
        uppercase: function (a) { return String.prototype.toUpperCase.call(a) }, lowercase: function (a) { return String.prototype.toLowerCase.call(a) }, "default": function (a, b) { return "" === a || null == a ? b : a }, replace: function (a, b, c) { return String.prototype.replace.call(a, b, c) }, fit: function (a, b, c, d) {
            if (b && ("" + a).length > b) switch (c = "" + (c || "..."),
            b -= c.length, a = "" + a, d) { case "left": return c + a.slice(-b); case "middle": return d = Math.ceil(b / 2), a.substr(0, d) + c + a.slice(d - b); default: return a.substr(0, b) + c } else return a
        }, json: function (a, b, c) { return d.toJSON(a, c, b) }, number: function (a) { return (+a).toLocaleString() }
    }; g.textFilter = { preprocessor: s, enableForBinding: z }; var B = "."; y(/([^\.]+)\.(.+)/, function (a, b) { var c = a[1], e = d.bindingHandlers[c]; if (e) return c = (e.getNamespacedHandler || t).call(e, a[2], c, b), d.bindingHandlers[b] = c }); g.namespacedBinding = {
        defaultGetHandler: t,
        setDefaultBindingPreprocessor: u, preprocessor: A, enableForBinding: m
    }; g.wrappedCallback = { preprocessor: l, enableForBinding: n }; g.preprocessBindingProperty = { setPreprocessor: p }; var G = v("$data,$event"); g.expressionCallback = { makePreprocessor: v, eventPreprocessor: G, enableForBinding: function (a, b) { b = Array.prototype.slice.call(arguments, 1).join(); k(a, v(b)) } }; d.bindingHandlers.on = { getNamespacedHandler: function (a) { a = d.getBindingHandler("event" + B + a); return k(a, G) } }; var I = g.interpolationMarkup = {
        preprocessor: D, enable: E,
        wrapExpresssion: function (a) { return [document.createComment("ko text:" + a), document.createComment("/ko")] }
    }, w = "data-bind"; g.attributeInterpolationMarkup = { preprocessor: F, enable: function () { r(F) } }
});