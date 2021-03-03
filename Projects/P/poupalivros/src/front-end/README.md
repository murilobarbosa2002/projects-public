![GV8](./tasks/gv8.png)

# Novo Workflow para desenvolvimento do Frontend

Para poder iniciar o projeto com este workflow, você precisará instalar as dependências do node

```sh
npm i
# ou
yarn install
```

Em seguida você rodará a tarefa "start"

```sh

gulp start

```

**Instalando novas libs e dependências**

Assim que você terminar a instalação via npm ou yarn, você precisa adiconá-la no arquivo "tasks.conf.js" conforme no exemplo abaixo:

```js
copyAll : [
	// add dentro dessa prop a sua lib conforme o exemplo do Font Awesome
	fontAwesome : {
		fonts : {
			src : 'node_modules/@fortawesome/fontawesome-free/webfonts/*',
			dist: 'dist/assets/webfonts/'
		},
		css : {
			src : 'node_modules/@fortawesome/fontawesome-free/css/all.css',
			dist: 'src/assets/scss/vendors/',
			// necessário apenas caso queira renomear o arquivo
			rename: '_font-awesome.scss'
		},
		variaveis: {
			src : 'node_modules/@fortawesome/fontawesome-free/scss/_variables.scss',
			dist: 'src/assets/scss/vendors/',
			// necessário apenas caso queira renomear o arquivo
			rename: '_font-awesome-variaveis.scss'
		}
	}

]
```

**Sprites**

Para poder trabalhar com sprites em SVG ou PNG, basta adicionar o arquivo do ícone na pasta "src/assets/sprites/{svg|png}" que o mesmo será gerado automaticamamente.
Depois para usá-lo em seu HTML basta fazer como no exemplo abaixo

```html
<i class="icon {{$fileName}}"></i>

<svg>
	<use xlink:href="#{{$fileName}}">
</svg>
```

**Application**

Esta é mais uma das novas ~~frescuras~~ novidades do Google. Para poder atende-la, basta usar esse site https://app-manifest.firebaseapp.com para gerar o "manifest.json" junto com todas os ícones exigidos pelo mesmo. Em seguida, extraia o aquivo baixado e salve na pasta "src/assets/application"

**Sobre o lazy-image**

O elemento **<lazy-image></lazy-image>**, é uma medida grotesca de usar o WEb Components enquanto as merdas dos browsers não dão total suporte para a API original.
Este componete, visa **"atrasar"** o carregamento das imagens para economizar recursos de banda optimizando, assim, o carregamento da página.
A sua utilização é como no exemplo abaixo:

```html
<lazy-image
    src="imagem.jpg"
    width="250"
    height="250"
    alt="Nome/Descrição"
    srcset="image-celular.jpg 240w, image-tablet.jpg 500w, image-netbook.jpg 900w, image-desktop.jpg 1100w"
    sizes="(max-width: 499px) 240w, (max-width: 899px) 500w, (max-width: 1200px)     900w, (min-with: 1200px) 1100w" >
</lazy-image>
```

**Observação:** Os attributos src, width e height são obrigatórios. Já o restante é meramente opcional

**Criou um lazy-image de forma dinâmica e deseja registrá-lo?**
Para tal, basta executar o seguinte código abaixo que é **GG**

```html
<script>
    Lazyimage.register('lazy-image');
</script>
```

Para obter informações extras sobre o **<lazy-image>**, rode o seguinte código:


```html
<script>
    Lazyimage.info();
</script>
```

**Finalizou o projeto?**

Após ter finalizado e/ou fez alguma ateração, **NÃO SE ESQUEÇA** de rodar a tarefa **gulp buld**, pois é ela quem vai identar o seu **HTML** e minificar seu **JS**

**Task List**

```console
├── app
├── app:watch
├── copy
├── fonts
├── fonts:watch
├── html
├── uglify
├── js
├── js:watch
├── imgs
├── imgs:watch
├── server
├── sass
├── sass:watch
├── pug
├── pug:watch
├── sprite:png
├── sprite:pngWatch
├── sprite:svg
├── sprite:svgWatch
├─┬ start
│ └─┬ <series>
│   ├── copy
│   ├── sprite:svg
│   ├── sprite:png
│   ├── pug
│   ├── fonts
│   ├── sass
│   ├── imgs
│   ├── js
│   └── app
├─┬ dev
│ └─┬ <parallel>
│   ├── fonts:watch
│   ├── imgs:watch
│   ├── js:watch
│   ├── pug:watch
│   ├── sass:watch
│   ├── sprite:pngWatch
│   ├── sprite:svgWatch
│   ├── app:watch
│   └── server
└─┬ build
  └─┬ <series>
    ├── html
    └── uglify
```

Encontrou algum erro ou quer sugerir alguma melhoria, envie um e-mail para frontend2gv8@gmail.com
