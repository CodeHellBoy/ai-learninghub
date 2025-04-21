from flask import Flask, request, jsonify, session
import requests
from flask_cors import CORS
from datetime import datetime

# ⚠ WARNING: Store API keys securely in environment variables
API_KEY = "948CuQn8f8q3ffO2RHBu6EMEtaDQFtIp"
MISTRAL_API_URL = "https://api.mistral.ai/v1/chat/completions"

# ✅ Flask App Setup
app = Flask(__name__)
app.secret_key = "your_secret_key"  # Required for session management
CORS(app)

# ✅ Keyword-based filtering logic
def is_educational_query(query):
    educational_keywords = [
        "learn", "study", "lesson", "course", "subject", "exam", "quiz", "syllabus", "certificate",
        "assignment", "homework", "tutorial", "lecture", "test", "educational", "career", "skill",
        "online class", "lms", "ai-lms", "teacher", "student", "instructor", "doubt", "revision",
        "e-learning", "academic", "coaching", "notes", "explanation", "concept", "university"
    ]

    programming_it_keywords = [
        "python", "java", "javascript", "php", "html", "css", "c++", "c#", "sql", "mysql",
        "mongodb", "flask", "django", "react", "angular", "laravel", "git", "github", "api",
        "debug", "bug", "code", "program", "script", "loop", "function", "variable", "database",
        "ai", "machine learning", "deep learning", "nlp", "computer vision", "data science",
        "cybersecurity", "cloud", "docker", "linux", "os", "network", "dbms", "cn", "compiler",
        "interpreter", "ide", "interview", "resume", "project"
    ]

    blocked_keywords = [
        "love", "date", "relationship", "crush", "boyfriend", "girlfriend",
        "joke", "funny", "meme", "celebrity", "actor", "singer", "movie", "film", "tv",
        "religion", "god", "prayer", "church", "mosque", "temple",
        "politics", "president", "government", "minister",
        "stock", "crypto", "money", "investment", "trading",
        "health", "doctor", "disease", "medicine", "hospital",
        "sports", "football", "cricket", "basketball", "game", "gaming",
        "news", "weather", "horoscope", "zodiac"
    ]

    query_lower = query.lower()

    if any(word in query_lower for word in blocked_keywords):
        return False

    if any(word in query_lower for word in educational_keywords + programming_it_keywords):
        return True

    return False  # Default to not allowed if not clearly educational

# ✅ Query Mistral API
def query_mistral(prompt):
    headers = {"Authorization": f"Bearer {API_KEY}", "Content-Type": "application/json"}
    data = {
        "model": "mistral-medium",
        "messages": [{"role": "user", "content": prompt}],
        "temperature": 0.7
    }
    try:
        response = requests.post(MISTRAL_API_URL, json=data, headers=headers)
        response.raise_for_status()
        return response.json().get("choices")[0].get("message").get("content", "")
    except Exception as e:
        print(f"❌ Mistral API Error: {e}")
        return "⚠ Error processing request. Please try again later."

# ✅ Chatbot Route
@app.route("/chatbot", methods=["POST"])
def chatbot():
    try:
        data = request.get_json()
        user_input = data.get("message", "").strip()

        if not user_input:
            return jsonify({"response": "⚠ Please provide a valid message."}), 400

        print(f"📥 User input received: {user_input}")

        # ⚠️ Apply keyword filtering
        if not is_educational_query(user_input):
            return jsonify({"response": "❌ This chatbot only answers educational, programming, or IT-related questions."})

        # Initialize chat history in session
        if "chat_history" not in session:
            session["chat_history"] = []

        # 📚 AI-LMS Simple and Reliable Prompt
        ai_lms_prompt = f"""
        You are an AI-LMS chatbot designed to assist users with learning and education-related queries. 
        Your goal is to respond in a way that is **short**, **simple**, and **accurate**.

        📌 Guidelines:
        - Use clear and easy-to-understand language (no jargon unless explained).
        - Keep your answers brief, around 3–6 sentences max unless asked for more detail.
        - Always provide reliable and factual responses.
        - If the question requires steps, summarize briefly.
        - Avoid overexplaining unless the user asks for more details.

        📢 User Query:  
        {user_input}

        📖 Response Format:  
        👉 Simple explanation of the concept  
        ✅ One key tip or example (if relevant)  
        💡 Encouraging or motivational closing sentence (optional)  
        """

        ai_text = query_mistral(ai_lms_prompt).strip()
        print(f"🤖 AI Response: {ai_text}")

        # Store chat history
        timestamp = datetime.now().isoformat()
        session["chat_history"].append({
            "timestamp": timestamp,
            "user": user_input,
            "bot": ai_text
        })

        return jsonify({"response": ai_text, "chat_history": session["chat_history"]})

    except Exception as e:
        print(f"💥 Internal Server Error: {e}")
        return jsonify({"response": f"⚠ Server error occurred: {str(e)}"}), 500

# ✅ Chat History Endpoint
@app.route("/chat-history", methods=["GET"])
def get_chat_history():
    return jsonify({"chat_history": session.get("chat_history", [])})

if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=8080)
