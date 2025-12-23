# Cloudflare Turnstile Setup

Este documento explica como configurar o Cloudflare Turnstile para proteger os formulários de lead contra spam.

## O que é Cloudflare Turnstile?

Cloudflare Turnstile é uma alternativa ao reCAPTCHA que oferece proteção contra bots sem exigir que os usuários resolvam desafios visuais. É gratuito e mais amigável ao usuário.

## Pacote Utilizado

Este projeto usa o pacote oficial do Laravel: [ryangjchandler/laravel-cloudflare-turnstile](https://github.com/ryangjchandler/laravel-cloudflare-turnstile)

## ⚠️ Não precisa mover o DNS!

**IMPORTANTE**: O Cloudflare Turnstile funciona **sem mover seu DNS** para o Cloudflare. Você pode:
- Manter seu DNS onde está (GoDaddy, Namecheap, Route53, etc.)
- Usar o Turnstile normalmente
- Apenas criar uma conta gratuita no Cloudflare para acessar o Turnstile

O Turnstile é um serviço independente que não requer gerenciamento de DNS pelo Cloudflare.

## Como obter as credenciais

### 1. Acesse o Cloudflare Dashboard

1. Acesse [https://dash.cloudflare.com/](https://dash.cloudflare.com/)
2. **Crie uma conta gratuita** se não tiver uma (não precisa adicionar domínio)
3. Se já tiver conta, faça login

### 2. Navegue até Turnstile (sem adicionar domínio)

1. Acesse diretamente: [https://dash.cloudflare.com/?to=/:account/turnstile](https://dash.cloudflare.com/?to=/:account/turnstile)
2. Ou no menu lateral, procure por **"Turnstile"** (pode estar em "Security" ou diretamente no menu)
3. **Ignore qualquer prompt para adicionar domínio ao Cloudflare DNS** - você não precisa disso!

### 3. Crie um novo site no Turnstile

1. Na página do Turnstile, clique em **"Add Site"** ou **"Adicionar Site"**
2. Preencha os campos:
   - **Site name**: Nome descritivo (ex: "Rogerio Pereira Lead Forms")
   - **Domain**: Seu domínio completo (ex: `seusite.com` ou `*.seusite.com` para incluir subdomínios)
     - **Importante**: Use o domínio onde o formulário será usado, mesmo que o DNS não esteja no Cloudflare
   - **Widget mode**: Escolha **"Managed"** (recomendado) ou **"Non-interactive"**
3. Clique em **"Create"**
4. **Não se preocupe** se aparecer alguma mensagem sobre DNS - você pode ignorar, o Turnstile funcionará normalmente

### 4. Obtenha as chaves

Após criar o site, você verá:
- **Site Key**: Chave pública (usada no frontend)
- **Secret Key**: Chave privada (usada no backend - mantenha segura!)

## Configuração no Laravel

### 1. O pacote já está instalado

O pacote `ryangjchandler/laravel-cloudflare-turnstile` já está instalado no projeto.

### 2. Adicione as variáveis de ambiente

Adicione as seguintes linhas no seu arquivo `.env`:

```env
TURNSTILE_SITE_KEY=sua_site_key_aqui
TURNSTILE_SECRET_KEY=sua_secret_key_aqui
```

### 3. Exemplo de valores

```env
TURNSTILE_SITE_KEY=0x4AAAAAAABkMYinukE8K5X0
TURNSTILE_SECRET_KEY=0x4AAAAAAABkMYinukE8K5X0_abcdefghijklmnopqrstuvwxyz
```

**⚠️ IMPORTANTE**: 
- Nunca commite o arquivo `.env` no Git
- A Secret Key deve ser mantida em segredo
- Use chaves diferentes para desenvolvimento e produção

### 4. Configuração automática

A configuração já está feita em `config/services.php`. O pacote detecta automaticamente as variáveis de ambiente.

## Modo de teste

Para testar localmente sem configurar um domínio real, você pode usar as chaves de teste fornecidas pela Cloudflare:

- **Site Key de teste**: `1x00000000000000000000AA`
- **Secret Key de teste**: `1x0000000000000000000000000000000AA`

Essas chaves sempre retornam sucesso na validação, permitindo testar a integração localmente.

**Nota**: Nos testes automatizados, o pacote usa `Turnstile::fake()` para simular validações bem-sucedidas automaticamente.

## Verificação

Após configurar:

1. Acesse um dos formulários de lead:
   - `/automation`
   - `/marketing`
   - `/software-development`

2. Você deve ver o widget Turnstile antes do botão de submit

3. Ao submeter o formulário, o token será validado automaticamente

4. Se a validação falhar, uma mensagem de erro será exibida

## Troubleshooting

### Cloudflare pede para mover o DNS

**Solução**: Ignore essa mensagem! O Turnstile funciona sem mover o DNS. Apenas:
1. Acesse diretamente: https://dash.cloudflare.com/?to=/:account/turnstile
2. Crie o site no Turnstile normalmente
3. Use as chaves geradas - funcionarão mesmo sem DNS no Cloudflare

### Widget não aparece

- Verifique se `TURNSTILE_SITE_KEY` está configurado no `.env`
- Verifique se o script do Turnstile está carregando (inspecione o console do navegador)
- Certifique-se de que o domínio está registrado no Cloudflare Turnstile (mesmo que o DNS não esteja no Cloudflare)

### Validação sempre falha

- Verifique se `TURNSTILE_SECRET_KEY` está correto no `.env`
- Verifique os logs do Laravel para mensagens de erro
- Certifique-se de que o domínio do site está na lista de domínios permitidos no Turnstile
- **Importante**: O domínio precisa estar cadastrado no Turnstile, mas o DNS pode estar em qualquer provedor

### Erro "Invalid site key"

- Verifique se a Site Key está correta
- Certifique-se de que o domínio atual está registrado no Turnstile
- Para desenvolvimento local, use as chaves de teste

## Recursos

- [Documentação oficial do Turnstile](https://developers.cloudflare.com/turnstile/)
- [Dashboard do Turnstile](https://dash.cloudflare.com/?to=/:account/turnstile)
- [Guia de integração](https://developers.cloudflare.com/turnstile/get-started/server-side-rendering/)
