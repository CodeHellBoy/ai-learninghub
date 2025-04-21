import requests
from flask import Flask, render_template, request, jsonify

app = Flask(__name__)

# Mistral AI API Key (Use environment variables in production)
API_KEY = "uxujs1O9v9Q9jWq4ARYlyagwxEBLVL73"
MISTRAL_API_URL = "https://api.mistral.ai/v1/chat/completions"

# Chat history storage
chat_history = []

def get_chatbot_response(user_message):
    """Fetch response from Mistral AI API with an educational constraint"""
    try:
        headers = {"Authorization": f"Bearer {API_KEY}", "Content-Type": "application/json"}
        payload = {
            "model": "mistral-tiny",
            "messages": [
                {"role": "system", "content": "You are an AI chatbot that only provides educational answers. Avoid non-educational topics."},
                {"role": "user", "content": user_message}
            ],
            "max_tokens": 200
        }
        response = requests.post(MISTRAL_API_URL, json=payload, headers=headers)
        response_data = response.json()
        
        return response_data.get("choices", [{}])[0].get("message", {}).get("content", "⚠️ Error: Invalid response from API.").strip()
    except requests.exceptions.RequestException as e:
        return f"⚠️ API Error: {str(e)}"
    except Exception as e:
        return f"⚠️ Unexpected Error: {str(e)}"

@app.route("/")
def home():
    return render_template("index.html")

@app.route("/chat", methods=["POST"])
def chat():
    user_message = request.json.get("message", "").strip()
    if not user_message:
        return jsonify({"error": "Empty message"}), 400
    
    bot_response = get_chatbot_response(user_message)
    chat_history.append({"user": user_message, "bot": bot_response})
    
    return jsonify({"response": bot_response})

if __name__ == "__main__":
    app.run(debug=True)
