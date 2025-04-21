<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Hub - AI LMS</title>
    <link rel="icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/php/AI-LMS/assets/img/lear1_icon.ico" type="image/x-icon">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #0f172a; color: #e2e8f0; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .chat-container { width: 400px; background: #1e293b; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); }
        .chat-box { height: 350px; overflow-y: auto; border-radius: 8px; padding: 15px; background: #334155; }
        .chat-message { padding: 8px 12px; margin: 8px 0; border-radius: 6px; max-width: 80%; }
        .user-message { background: #3b82f6; text-align: right; margin-left: auto; color: white; }
        .bot-message { background: #64748b; text-align: left; color: white; }
        .chat-input-container { display: flex; gap: 10px; margin-top: 10px; }
        .chat-input { flex: 1; padding: 10px; border-radius: 6px; border: none; outline: none; background: #475569; color: white; }
        .send-btn, .delete-btn { padding: 10px; border-radius: 6px; border: none; cursor: pointer; transition: 0.3s; }
        .send-btn { background: #10b981; color: white; }
        .send-btn:hover { background: #059669; }
        .delete-btn { background: #ef4444; color: white; margin-top: 10px; width: 100%; }
        .delete-btn:hover { background: #dc2626; }
        body{
            background-image: url('https://images.unsplash.com/photo-1612838320302-4b3b3b3b3b3b');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- <h2 style="text-align:center;">AI LMS Chatbot</h2> -->
        <div class="chat-box" id="chat-box"></div>
        <div class="chat-input-container">
            <input type="text" id="user-message" class="chat-input" placeholder="Type a message..." required>
            <button id="send-btn" class="send-btn">Send</button>
        </div>
        <button id="clear-btn" class="delete-btn">Clear Chat</button>
    </div>
    
    <script>
        document.getElementById("send-btn").addEventListener("click", sendMessage);
        document.getElementById("user-message").addEventListener("keypress", function(event) {
            if (event.key === "Enter") sendMessage();
        });
        document.getElementById("clear-btn").addEventListener("click", clearChat);

        function sendMessage() {
            let userInput = document.getElementById("user-message");
            let message = userInput.value.trim();
            if (message === "") return;
            appendMessage("user", message);
            userInput.value = "";

            fetch("http://127.0.0.1:8080/chatbot", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => appendMessage("bot", data.response))
            .catch(error => appendMessage("bot", "⚠️ Error: Unable to fetch response."));
        }

        function appendMessage(sender, message) {
            let chatBox = document.getElementById("chat-box");
            let messageDiv = document.createElement("div");
            messageDiv.classList.add("chat-message", sender === "user" ? "user-message" : "bot-message");
            messageDiv.textContent = message;
            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function clearChat() {
            document.getElementById("chat-box").innerHTML = "";
        }
    </script>
</body>
</html>