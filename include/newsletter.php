<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Newsletter Signup</title>
  <style>
    .newsletter {
      text-align: center;
      margin: 40px auto;
      padding: 30px;
      background-color: #f9f9f9;
      max-width: 400px;
    }
    >
    .newsletter {
      text-align: center;
      margin: 40px auto;
      padding: 30px;
      background-color: #e0e0e0; /* slightly darker gray */
      max-width: 400px;
      border-radius: 8px;
    }
    .newsletter h3 {
      margin: 0 0 10px;
      font-size:10px;
      font-weight: bold; /* make it bold */
      color: #000;        /* make it black */
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .newsletter p {
      margin: 0 0 20px;
      font-size: 1.3rem; /* bigger paragraph text */
      color: #333;
      line-height: 1.6;
    }
    .newsletter form {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }
    .newsletter input[type="email"] {
      padding: 10px;
      width: 80%;
      border: none;
      border-bottom: 2px solid #000; /* only bottom border */
      font-size: 1rem;
      text-align: center;
      outline: none;
      background: transparent;
    }
    .newsletter button {
      padding: 10px 20px;
      background-color: #000;
      color: #fff;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s;
      width: auto; /* not full width */
    }
    .newsletter button:hover {
      background-color: #333;
    }
  </style>
</head>
<body>

  <div class="newsletter">
    <h3>Newsletter</h3>
    <p>New Fragrances,<br>exclusive offers and<br> events.</p>
    <form>
      <input type="email" placeholder="Enter your email adress" required />
      <button type="submit">Subscribe</button>
    </form>
  </div>
</body>
</html>