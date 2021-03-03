# Sobre o Owl Carousel

Visto que houveram algumas dores de cabeça com o **Owl Carousel** com carregamento dinâmico, foi criado um método em **jQuery** para facilitar a nossa vida.

Agora, sempre que precisar substituir o conteúdo do **owl carousel**, basta fazer como no exemplo abaixo:

```js

$('.owl-carousel#meuID').replaceOwlContent($data); // onde $data = ao retorno da requisição.

```
