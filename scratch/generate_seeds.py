import random

categories = ["Protein", "Mass Gainer", "Pre-Workout", "Vegan", "Aminos", "Strength"]
adjectives = ["Titan", "Elite", "Pro", "Ultra", "Max", "Nitro", "Eco", "Pure", "Alpha", "Zen", "Thunder", "Rocket", "Savage", "Prime"]
flavors = ["Chocolate", "Vanilla", "Strawberry", "Cookies & Cream", "Berry Blast", "Coffee Bean", "Mango Madness", "Iced Tea", "Unflavored"]

products_sql = []
reviews_sql = []

product_id = 7 # Starting after initial seeds

reviews_templates = [
    "Amazing product! I've seen massive gains in just 2 weeks.",
    "Best taste in the market, no bloating at all.",
    "A bit expensive but worth every penny for the purity.",
    "Highly recommended for clean bulking. 10/10.",
    "Solid results, mixability is 100%.",
    "Natural ingredients really make a difference in recovery.",
    "Energy is through the roof with this one!",
    "Finally a vegan protein that doesn't taste like dirt.",
    "Strength gains are undeniable. Broke my PR today!"
]

for cat in categories:
    for i in range(21):
        name = f"{random.choice(adjectives)} {cat} - {random.choice(flavors)}".replace("'", "''")
        desc = f"Premium {cat} formulated with {random.choice(['clean', 'high-grade', 'organic', 'purified'])} ingredients to support your fitness journey. {random.choice(['Fast absorbing', 'Slow release', 'Sustained energy', 'Zero fillers'])} for maximum results.".replace("'", "''")
        price = random.randint(999, 4999)
        stock = random.randint(10, 500)
        nutrition = f"Protein: {random.randint(20, 30)}g, Carbs: {random.randint(0, 5)}g, Fat: {random.randint(0, 2)}g"
        
        # Determine image based on category
        img_map = {
            "Protein": "https://images.unsplash.com/photo-1593095948071-474c5cc2989d?w=400",
            "Mass Gainer": "https://images.unsplash.com/photo-1579722820308-d74e5719d38e?w=400",
            "Pre-Workout": "https://images.unsplash.com/photo-1546483875-ad9014c88eba?w=400",
            "Vegan": "https://images.unsplash.com/photo-1594950119330-316279f06114?w=400",
            "Aminos": "https://images.unsplash.com/photo-1512149177596-f817c7ef5d4c?w=400",
            "Strength": "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400"
        }
        img = img_map.get(cat, img_map["Protein"])

        products_sql.append(f"INSERT INTO products (name, description, price, category, image_url, stock, nutrition_facts) VALUES ('{name}', '{desc}', {price}, '{cat}', '{img}', {stock}, '{nutrition}');")
        
        # Generate 3-5 reviews per product
        for _ in range(random.randint(3, 6)):
            rating = random.randint(4, 5) # MB level products get high ratings
            msg = random.choice(reviews_templates).replace("'", "''")
            reviews_sql.append(f"INSERT INTO reviews (product_id, user_id, rating, comment) VALUES ({product_id}, 1, {rating}, '{msg}');")
            
        product_id += 1

with open("c:/Users/ADMIN/OneDrive/Desktop/GreenBulk/database/seed_125_items.sql", "w") as f:
    f.write("-- Reset Tables\nSET FOREIGN_KEY_CHECKS = 0;\nTRUNCATE TABLE products;\nTRUNCATE TABLE reviews;\nTRUNCATE TABLE users;\nSET FOREIGN_KEY_CHECKS = 1;\n\n")
    f.write("INSERT INTO users (id, name, email, password_hash) VALUES (1, 'Admin', 'admin@greenbulk.com', 'admin_pass');\n\n")
    f.write("\n".join(products_sql))
    f.write("\n\n")
    f.write("\n".join(reviews_sql))

print("SQL seed file generated with 125 products and 500+ reviews.")
