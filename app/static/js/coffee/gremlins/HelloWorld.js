(function() {
  var HelloWorld,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  HelloWorld = (function(_super) {
    __extends(HelloWorld, _super);

    function HelloWorld() {
      HelloWorld.__super__.constructor.apply(this, arguments);
      this.el.innerHTML = "Hello World " + this.id;
    }

    return HelloWorld;

  })(G.Gizmo);

  G.add('HelloWorld', HelloWorld);

}).call(this);

//# sourceMappingURL=HelloWorld.js.map
