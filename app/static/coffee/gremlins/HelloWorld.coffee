class HelloWorld extends G.Gizmo
  constructor : ->
    super
    @el.innerHTML = "Hello World #{@id}"

G.add 'HelloWorld', HelloWorld
