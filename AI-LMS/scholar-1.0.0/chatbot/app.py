from flask import Flask, request, jsonify, session
import requests
from flask_cors import CORS

# ⚠ WARNING: Store API keys securely in environment variables
API_KEY = "948CuQn8f8q3ffO2RHBu6EMEtaDQFtIp"
MISTRAL_API_URL = "https://api.mistral.ai/v1/chat/completions"

# ✅ Flask App Setup
app = Flask(__name__)
app.secret_key = "your_secret_key"  # Required for session management
CORS(app)

def query_mistral(prompt):
    headers = {"Authorization": f"Bearer {API_KEY}", "Content-Type": "application/json"}
    data = {
        "model": "mistral-medium",  # Adjust model if needed
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

@app.route("/chatbot", methods=["POST"])
def chatbot():
    try:
        data = request.get_json()
        user_input = data.get("message", "").strip()

        if not user_input:
            return jsonify({"response": "⚠ Please provide a valid message."}), 400

        print(f"📥 User input received: {user_input}")

        # Initialize chat history in session
        if "chat_history" not in session:
            session["chat_history"] = []

        # 📚 Classification Prompt - Strictly Education Related or Not (Including IT Courses and Languages)
        classification_prompt = f"""
        You are an AI-LMS chatbot. Classify the user query based on the following conditions:

        1️⃣ If the query is about education (courses, subjects, exams, study materials, academic guidance, IT programming languages like Python, Java, C++, JavaScript, etc., or IT-related courses such as Cybersecurity, Data Science, AI, Machine Learning, Cloud Computing), reply exactly with 'Education Related'.

        2️⃣ If the query is a code snippet, detect the programming language and reply exactly with the language name (e.g., 'Python', 'Java', 'C++', 'JavaScript', 'PHP', etc.).

        3️⃣ If the query contains inappropriate, offensive, irrelevant, or gibberish content, reply exactly with 'Not Education Related'.

        4️⃣ If the query is neither education-related nor a code snippet, reply exactly with 'Not Education Related'.

        5️⃣ If the query does not match any of the above classifications, reply exactly with 'Not Education Related'.

        User Query: {user_input}
        """

        classification_text = query_mistral(classification_prompt).strip()
        print(f"🧵 Classification Result: {classification_text}")

        if classification_text == "Not Education Related":
            return jsonify({"response": "❌ This chatbot only answers education-related queries."})

        elif classification_text in ["Python", "Java", "C++", "JavaScript", "PHP", "C", "Ruby", "Go", "Swift", "Kotlin", "R", "TypeScript"]:
            # 🧠 Code-Specific Response
            ai_lms_prompt = f"""
You are an AI-LMS chatbot. The user has provided a code snippet written in {classification_text}.
Analyze the code and provide a clear, concise explanation, debugging help, or optimization suggestions.

User Code Query: {user_input}
"""
        else:
            # 🧠 General Education Response
            ai_lms_prompt = f"""
You are an AI-LMS chatbot. Respond to the user's question in a concise and relevant manner.
Ensure that the answer is short, clear, and directly addresses the query without unnecessary details.

User Query: {user_input}
"""

        # 🎯 Strictly Education-Only Filter
        education_only_prompt = f"""
You are an AI chatbot strictly limited to educational topics only.
If the user's question is related to education, provide an informative response.
If it is unrelated to education, reply exactly with '❌ This chatbot only answers education-related queries.'.

User Query: {user_input}
"""

        education_filter = query_mistral(education_only_prompt).strip()
        if education_filter == "❌ This chatbot only answers education-related queries.":
            return jsonify({"response": education_filter})

        ai_text = query_mistral(ai_lms_prompt).strip()
        print(f"🤖 AI Response: {ai_text}")

        # Store conversation in chat history
        session["chat_history"].append({"user": user_input, "bot": ai_text})

        return jsonify({"response": ai_text, "chat_history": session["chat_history"]})

    except Exception as e:
        print(f"💥 Internal Server Error: {e}")
        return jsonify({"response": f"⚠ Server error occurred: {str(e)}"}), 500

@app.route("/chat-history", methods=["GET"])
def get_chat_history():
    """Retrieve chat history"""
    return jsonify({"chat_history": session.get("chat_history", [])})

if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=8080)
