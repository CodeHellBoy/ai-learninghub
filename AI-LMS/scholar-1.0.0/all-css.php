<meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

<!-- CSS Files -->
 <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
<style>
    .chatbot-popup {
    z-index: 9999; /* Ensure it's on top */
}

.chatbot-popup .chatbot-popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.chatbot-popup .chatbot-popup-header h4 {
    margin: 0;
    color: #fff;
}

.chatbot-popup .chatbot-popup-header button {
    background: none;
    border: none;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
}

.chatbot-popup .chatbot-popup-body {
    height: 400px;
    overflow-y: auto;
    padding: 10px;
    background: #334155;
    border-radius: 8px;
}

.chatbot-popup .chatbot-popup-body .chatbot-message {
    padding: 8px 12px;
    margin: 8px 0;
    border-radius: 6px;
    max-width: 80%;
}

.chatbot-popup .chatbot-popup-body .user-message {
    background: #3b82f6;
    text-align: right;
    margin-left: auto;
    color: white;
}

.chatbot-popup .chatbot-popup-body .bot-message {
    background: #64748b;
    text-align: left;
    color: white;
}

.chatbot-popup .chatbot-popup-footer {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.chatbot-popup .chatbot-popup-footer .chatbot-input {
    flex: 1;
    padding: 10px;
    border-radius: 6px;
    border: none;
    outline: none;
    background: #475569;
    color: white;
}

.chatbot-popup .chatbot-popup-footer .send-btn,
.chatbot-popup .chatbot-popup-footer .delete-btn {
    padding: 10px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.chatbot-popup .chatbot-popup-footer .send-btn {
    background: #10b981;
    color: white;
}

.chatbot-popup .chatbot-popup-footer .send-btn:hover {
    background: #059669;
}

.chatbot-popup .chatbot-popup-footer .delete-btn {
    background: #ef4444;
    color: white;
    margin-top: 10px;
    width: 100%;
}

.chatbot-popup .chatbot-popup-footer .delete-btn:hover {
    background: #dc2626;
}

</style>