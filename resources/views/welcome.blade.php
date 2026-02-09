<div style="display:flex; justify-content:center; align-items:center; height:100vh; background:#f0f2f5; font-family:sans-serif;">
    <div style="background:white; padding:30px; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.1); text-align:center;">
        <h2 style="margin-bottom:20px;">Library Admin Access</h2>
        <form action="/login" method="POST">
            @csrf
            <input type="password" name="password" placeholder="Password" style="padding:10px; border:1px solid #ccc; border-radius:4px;">
            <br><br>
            <button type="submit" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:4px; cursor:pointer;">Masuk</button>
        </form>
    </div>
</div>