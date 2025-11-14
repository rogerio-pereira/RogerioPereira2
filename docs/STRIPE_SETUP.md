# Configuração do Stripe para Venda de Ebooks

Este documento explica como configurar o Stripe para funcionar com o sistema de venda de ebooks.

## 1. Criar Conta no Stripe

1. Acesse [https://stripe.com](https://stripe.com)
2. Crie uma conta (ou faça login se já tiver)
3. Complete o processo de verificação da conta

## 2. Obter Chaves da API

### Modo de Teste (Development)

1. No Dashboard do Stripe, vá em **Developers** → **API keys**
2. Certifique-se de estar no modo **Test mode** (toggle no canto superior direito)
3. Copie as seguintes chaves:
   - **Publishable key** (começa com `pk_test_...`)
   - **Secret key** (começa com `sk_test_...`)

### Modo de Produção (Production)

1. No Dashboard do Stripe, altere para **Live mode** (toggle no canto superior direito)
2. Copie as chaves de produção:
   - **Publishable key** (começa com `pk_live_...`)
   - **Secret key** (começa com `sk_live_...`)

## 3. Configurar Variáveis de Ambiente

Adicione as seguintes variáveis no arquivo `.env`:

```env
# Stripe Keys
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...

# Stripe Webhook Secret (será configurado na próxima etapa)
STRIPE_WEBHOOK_SECRET=whsec_...
```

**Importante:**
- Use chaves de **teste** (`pk_test_` e `sk_test_`) durante o desenvolvimento
- Use chaves de **produção** (`pk_live_` e `sk_live_`) apenas quando o site estiver em produção
- **NUNCA** compartilhe suas chaves secretas publicamente

## 4. Configurar Webhooks

Os webhooks permitem que o Stripe notifique sua aplicação quando eventos importantes acontecem (como pagamento concluído).

### 4.1. Configurar Webhook Local (Desenvolvimento)

O projeto já está configurado com o Stripe CLI como um serviço Docker. Não é necessário instalar nada manualmente!

1. **Iniciar os containers:**
   ```bash
   ./vendor/bin/sail up -d
   ```
   
   O container `stripe-cli` será iniciado automaticamente e começará a encaminhar webhooks para sua aplicação.

2. **Obter o webhook signing secret:**
   
   Verifique os logs do container Stripe CLI:
   ```bash
   ./vendor/bin/sail logs stripe-cli
   ```
   
   Procure por uma linha que mostra:
   ```
   > Ready! Your webhook signing secret is whsec_...
   ```

3. **Adicionar o secret ao `.env`:**
   
   Copie o valor `whsec_...` e adicione no seu arquivo `.env`:
   ```env
   STRIPE_WEBHOOK_SECRET=whsec_...
   ```

4. **Reiniciar a aplicação (se necessário):**
   ```bash
   ./vendor/bin/sail restart
   ```

**Nota:** 
- O container `stripe-cli` usa automaticamente a variável `STRIPE_SECRET` do seu `.env` para autenticação. Certifique-se de que essa variável está configurada corretamente.
- As configurações do Stripe CLI são persistidas em um volume Docker (`.stripe/` na raiz do projeto), o que ajuda a manter o mesmo webhook signing secret mesmo quando os containers são recriados. No entanto, se você fizer `sail down` e `sail up`, um novo secret pode ser gerado. Para manter o mesmo secret, use apenas `sail restart`.

**Alternativa (sem Docker):**
Se preferir usar o Stripe CLI localmente ao invés do container:

1. **Instalar Stripe CLI:**
   - macOS: `brew install stripe/stripe-cli/stripe`
   - Windows: Baixe de [https://github.com/stripe/stripe-cli/releases](https://github.com/stripe/stripe-cli/releases)
   - Linux: Siga as instruções em [https://stripe.com/docs/stripe-cli](https://stripe.com/docs/stripe-cli)

2. **Fazer login:**
   ```bash
   stripe login
   ```

3. **Iniciar o webhook forwarding:**
   ```bash
   stripe listen --forward-to http://localhost/stripe/webhook
   ```

### 4.2. Configurar Webhook em Produção

1. No Dashboard do Stripe, vá em **Developers** → **Webhooks**
2. Clique em **Add endpoint**
3. Configure:
   - **Endpoint URL**: `https://seudominio.com/stripe/webhook`
   - **Events to send**: Selecione os seguintes eventos:
     - `payment_intent.succeeded`
     - `payment_intent.payment_failed`
     - `payment_intent.canceled`
4. Clique em **Add endpoint**
5. Copie o **Signing secret** (começa com `whsec_...`)
6. Adicione no `.env` de produção:
   ```env
   STRIPE_WEBHOOK_SECRET=whsec_...
   ```

## 5. Testar a Integração

### 5.1. Cartões de Teste

O Stripe fornece cartões de teste para simular pagamentos:

**Cartão de sucesso:**
- Número: `4242 4242 4242 4242`
- Data de expiração: Qualquer data futura (ex: `12/25`)
- CVC: Qualquer 3 dígitos (ex: `123`)
- CEP: Qualquer CEP válido (ex: `12345`)

**Outros cartões de teste:**
- `4000 0000 0000 0002` - Cartão recusado
- `4000 0000 0000 9995` - Fundos insuficientes
- Veja mais em: [https://stripe.com/docs/testing](https://stripe.com/docs/testing)

### 5.2. Testar o Fluxo Completo

1. Certifique-se de que os containers estão rodando:
   ```bash
   ./vendor/bin/sail ps
   ```
   
   Você deve ver o container `stripe-cli` na lista.

2. Acesse `/shop` no seu site
3. Clique em um ebook
4. Preencha os dados:
   - Nome completo
   - Email
   - Telefone (opcional)
   - Dados do cartão de crédito
5. Use o cartão de teste `4242 4242 4242 4242`
   - Data de expiração: Qualquer data futura (ex: `12/25`)
   - CVC: Qualquer 3 dígitos (ex: `123`)
6. Clique em "Buy Now"
7. Complete o pagamento (o pagamento acontece na mesma página, sem redirecionamento)
8. Verifique se foi redirecionado para a página de sucesso
9. Verifique no Dashboard do Stripe se o pagamento aparece
10. Verifique os logs do Stripe CLI para ver os webhooks sendo processados:
    ```bash
    ./vendor/bin/sail logs stripe-cli -f
    ```

## 6. Verificar Logs

Se algo não funcionar, verifique os logs:

```bash
# Laravel logs
./vendor/bin/sail artisan tail

# Ou
tail -f storage/logs/laravel.log

# Logs do Stripe CLI (webhooks)
./vendor/bin/sail logs stripe-cli

# Logs do Stripe CLI em tempo real
./vendor/bin/sail logs stripe-cli -f

# Verificar se o container Stripe CLI está rodando
./vendor/bin/sail ps | grep stripe-cli
```

## 7. Checklist de Produção

Antes de colocar em produção, certifique-se de:

- [ ] Ter uma conta Stripe verificada
- [ ] Usar chaves de produção (`pk_live_` e `sk_live_`)
- [ ] Configurar webhook em produção com a URL correta
- [ ] Adicionar o webhook secret de produção no `.env`
- [ ] Testar um pagamento real com valor baixo
- [ ] Configurar notificações por email (opcional, mas recomendado)
- [ ] Revisar as políticas de reembolso e termos de serviço

## 8. Recursos Adicionais

- [Documentação do Laravel Cashier](https://laravel.com/docs/cashier)
- [Documentação do Stripe Elements](https://stripe.com/docs/stripe-js)
- [Documentação do Stripe Payment Intents](https://stripe.com/docs/payments/payment-intents)
- [Dashboard do Stripe](https://dashboard.stripe.com)
- [Stripe Testing](https://stripe.com/docs/testing)
- [Stripe CLI Docker Image](https://hub.docker.com/r/stripe/stripe-cli)

## 9. Troubleshooting

### Problemas com o Container Stripe CLI

**Container não inicia:**
```bash
# Verificar se o container está rodando
./vendor/bin/sail ps | grep stripe-cli

# Ver logs do container
./vendor/bin/sail logs stripe-cli

# Reiniciar o container
./vendor/bin/sail restart stripe-cli
```

**Webhook secret não aparece nos logs:**
- Aguarde alguns segundos após iniciar os containers
- O Stripe CLI precisa de tempo para se conectar ao Stripe
- Verifique se `STRIPE_SECRET` está configurado corretamente no `.env`

**Webhooks não estão chegando:**
- Verifique se o container `stripe-cli` está rodando: `./vendor/bin/sail ps`
- Verifique os logs em tempo real: `./vendor/bin/sail logs stripe-cli -f`
- Certifique-se de que o `STRIPE_WEBHOOK_SECRET` no `.env` corresponde ao secret mostrado nos logs
- Verifique se a rota `/stripe/webhook` está acessível

**Erro de autenticação:**
- Verifique se `STRIPE_SECRET` está configurado no `.env`
- Certifique-se de que está usando a chave secreta (começa com `sk_test_` ou `sk_live_`), não a chave pública

## 10. Suporte

Se tiver problemas:
1. Verifique os logs do Laravel: `./vendor/bin/sail artisan tail`
2. Verifique os logs do Stripe CLI: `./vendor/bin/sail logs stripe-cli -f`
3. Verifique os logs do Stripe Dashboard (Developers → Logs)
4. Consulte a documentação oficial do Stripe
5. Entre em contato com o suporte do Stripe se necessário

