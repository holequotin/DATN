from flask import Flask, jsonify, request
from chat import handle_response
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

@app.route('/chat/', methods=['POST'])
def chat():
    response = {
        'code_status': 200,
        'response': handle_response(request.form.get('question'))
    }
    insert_into_file(request.form.get('question'))
    return jsonify(response)

def insert_into_file(question):
    file_path = "conservation.txt"

    with open(file_path, "a") as file:
        file.write(question + "\n")

if __name__ == '__main__':
    app.run()
