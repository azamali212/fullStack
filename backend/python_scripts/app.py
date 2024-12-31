from flask import Flask, request, jsonify
import random

app = Flask(__name__)

@app.route('/generate_pricing', methods=['POST'])
def generate_pricing():
    base_price = 1000  # Base price in USD
    discount = random.randint(5, 20)
    final_price = base_price - (base_price * discount / 100)

    return jsonify({
        "base_price": base_price,
        "discount": discount,
        "final_price": final_price,
        "recommendation": "Register now to secure your spot!"
    })

if __name__ == "__main__":
    app.run(port=5001)
