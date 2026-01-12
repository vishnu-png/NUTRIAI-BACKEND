<?php
require 'config.php';

echo "<h2>Updating Food Macros...</h2>";

// Format: [Name keyword, Calories, Protein, Carbs, Fat]
$updates = [
    // Breakfast
    ['Idli', 60, 2, 8, 0.5],
    ['Dosa', 160, 3, 28, 4],
    ['Pongal', 210, 4, 30, 8],
    ['Upma', 180, 4, 30, 6],
    ['Poha', 180, 3, 35, 5],
    ['Paratha', 220, 5, 35, 10], // Aloo/Plain avg
    ['Bread', 70, 2.5, 13, 1], // Per slice
    ['Egg', 70, 6, 0.6, 5],
    ['Oats', 150, 5, 27, 3],
    ['Cereal', 120, 3, 25, 1],
    ['Smoothie', 150, 2, 25, 4],

    // Lunch / Dinner (Main)
    ['Rice', 130, 2.5, 28, 0.3], // White rice 100g cooked
    ['Brown Rice', 110, 2.6, 23, 0.9],
    ['Roti', 100, 3, 20, 2], // Chapati
    ['Naan', 260, 8, 45, 6],
    ['Dal', 120, 6, 18, 3], // Generic Dal
    ['Sambar', 100, 4, 15, 3],
    ['Rasam', 60, 1, 10, 2],
    ['Curd', 98, 11, 3.4, 4.3], // Yogurt/Curd
    ['Vegetable Curry', 140, 3, 12, 8],
    ['Paneer Butter Masala', 350, 12, 10, 28],
    ['Chicken Curry', 280, 22, 5, 18],
    ['Fish Curry', 220, 18, 4, 12],
    ['Veg Biryani', 250, 5, 40, 8],
    ['Chicken Biryani', 350, 18, 45, 12],
    ['Mutton Biryani', 450, 22, 45, 20],
    ['Fried Rice', 250, 5, 40, 9],
    ['Noodles', 280, 6, 45, 10],
    ['Chicken', 200, 25, 0, 8], // Grilled/Plain
    ['Fish', 180, 20, 0, 10], 
    ['Salad', 60, 1, 5, 3],

    // Snacks
    ['Samosa', 260, 4, 25, 16],
    ['Bajji', 150, 3, 20, 8],
    ['Biscuit', 70, 1, 10, 3],
    ['Nuts', 170, 6, 6, 15], // Handful
    ['Yogurt', 90, 8, 10, 3],
    ['Apple', 95, 0.5, 25, 0.3],
    ['Banana', 105, 1.3, 27, 0.3],
    ['Orange', 62, 1.2, 15, 0.2],
    ['Fruit Salad', 80, 1, 20, 0.5],

    // Drinks
    ['Milk', 150, 8, 12, 8], // 1 cup whole
    ['Tea', 40, 1, 8, 1], // With milk/sugar
    ['Coffee', 50, 1, 9, 1],
    ['Juice', 120, 0.5, 28, 0.2],

    // Fast Food
    ['Pizza', 285, 12, 36, 10],
    ['Burger', 450, 22, 40, 20],
    ['Pasta', 250, 8, 40, 5],
    
    // Meat & Seafood Extensions
    ['Prawns', 115, 24, 0, 1.7], // Raw/Cooked generic
    ['Prawn Curry', 200, 18, 6, 12],
    ['Prawn Fry', 250, 20, 8, 15],
    ['Mutton', 250, 25, 0, 15], // Generic meat
    ['Mutton Curry', 320, 22, 8, 22],
    ['Mutton Biryani', 450, 22, 45, 20],
    ['Mutton Fry', 350, 25, 5, 25],
    ['Beef', 250, 26, 0, 15],
    ['Beef Curry', 300, 22, 6, 18],
    ['Beef Fry', 350, 25, 5, 25],
    ['Pork', 240, 27, 0, 14],
    ['Pork Curry', 320, 22, 6, 22],
    ['Crab', 100, 18, 0, 1], // Meat only
    ['Crab Curry', 220, 16, 5, 14],
    
    // Generic Fallbacks (Run Last)
    ['Curry', 170, 4, 10, 12], // Generic vegetable/base gravy if not matched above
    
    // Remaining / Edge Cases
    ['Ghee', 120, 0, 0, 14], // 1 tbsp
    ['Oil', 120, 0, 0, 14],
    ['Butter', 100, 0, 0, 11],
    ['Pepsi', 150, 0, 38, 0],
    ['Coke', 150, 0, 38, 0],
    ['Soda', 150, 0, 38, 0], // Generic
    ['Water', 0, 0, 0, 0]
];

foreach ($updates as $item) {
    $name = $item[0];
    $cal = $item[1];
    $pro = $item[2];
    $carb = $item[3];
    $fat = $item[4];
    
    // Update query
    $sql = "UPDATE foods SET calories = $cal, protein = $pro, carbs = $carb, fat = $fat WHERE food_name LIKE '%$name%'";
    if ($conn->query($sql)) {
         echo "Updated $name: P:$pro C:$carb F:$fat (Affected: " . $conn->affected_rows . ")<br>";
    } else {
        echo "Error $name: " . $conn->error . "<br>";
    }
}
echo "Done.";
?>
