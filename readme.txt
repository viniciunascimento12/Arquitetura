Montagem ambiente
materiais:

linguagem Go
IDE Goland
Docker

**********************************************
Instalar o go e goland 
https://www.jetbrains.com/pt-br/go/

https://golang.org/doc/install

Instalar rabbitmq no windows

https://www.youtube.com/watch?v=V9DWKbalbWQ

Instalar Docker no windows

https://www.youtube.com/watch?v=1PoU2hBLaRs

Colocar o projeto na pasta www

caso náo tenha servidor local usar o wamp ou xampp

https://www.wampserver.com/en/

https://www.apachefriends.org/pt_br/index.html

******************************************************
Adicionando filas no Rabbitmq

http://localhost:15672 caso tenha instalado

Criar 3 Exchanges

checkout_ex
order_ex
pagamento_ex

pois elas receberão dados dos produtos

Criar 3 Queues

checkout_queue
order_queue
pagamento_queue

depois cara Queue recebe um bind de cada Exchange
basta clicar na exchange criar, ir no secção bind e colocar o nome da queue
Ex checkout_ex bind em checkout_queue

******************************************************
Ambiente do Goland

Abri um terminal para cada serviço

cd 'diretório do serviço'

Exemplo "cd catalogo" par entrar na pasta catalogo.

Rodar as variáveis de ambiente abaixo em cada terminal antes de primeira execuçã

set PRODUTO_URL=http://localhost:4000

set RABBITMQ_CONSUMER_FILA="checkout_queue"

Para executar os serviços

go run 'nome do arquivo e sua exetensão'

Exemplo "go run catalogo.go" caso queira rodar o catalogo.

Para o serviço de order tem dois comendos

go run order -opt checkout

go run order -opt pagamento
      
