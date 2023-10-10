async function sendMessage() {
  const botId = 'bot1715228462';
  const botToken = 'AAHr17T0K8A28sh__wYoM-GDw7LLnIbY6QQ';
  const chatId = 178435276;
  const text = 'Hello';

  const request = await fetch(
    `https://api.telegram.org/${botId}:${botToken}/sendMessage?chat_id=${chatId}&parse_mode=MarkdownV2&text=${text}`
  );
  const response = await request.json();
  console.log(response);
}

sendMessage();
