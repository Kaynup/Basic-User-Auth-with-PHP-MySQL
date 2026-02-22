'''
Password Hashing Strategy (Demo Disclaimer)

This project uses SHA2() for hashing passwords inside MySQL:

SHA2(password, 256)
Why SHA2 Is Not Recommended for Production

SHA2 is a fast cryptographic hashing algorithm. While it is secure for data integrity verification, it is not suitable for password storage in real-world applications because:

It is computationally fast (vulnerable to brute-force attacks)

It does not include automatic salting

It does not provide adaptive work factors

It is vulnerable to rainbow table attacks

Modern authentication systems should use:

password_hash() in PHP (bcrypt or Argon2)

Adaptive hashing algorithms with built-in salting

Configurable cost factors

Why It Is Used Here

SHA2 is used in this project strictly for:

Demonstration purposes

Understanding authentication flow

Practicing PDO and session handling

Educational experimentation

This project is not intended for production deployment.
'''


'''

PHASE 1 — Complete Core Authentication Properly

Goal: Convert your demo into a clean, minimal, structured authentication system.

We will implement:

Registration

Server-side validation

Secure login flow

Session regeneration

Basic architecture cleanup
'''

```mermaid
flowchart TD

    Browser[Browser]

    login[login.php]
    PDO[PDO]
    DB[(MySQL demobase.users)]
    verify[verify_password]

    session[Create Session Variables]
    uid[user_id]
    uname[username]

    dash["dashboard.php<br/>protected: checks session"]

    logout[logout.php]
    terminate[Terminate Session]


    Browser --> login

    login -->|POST| PDO
    PDO --> DB
    DB --> verify

    verify -->|success| session

    session --> uid
    session --> uname

    uid --> dash
    uname --> dash

    dash -->|logout| logout
    logout --> terminate
    terminate --> login


    %% Color definitions
    classDef client fill:#E3F2FD,stroke:#1E88E5,stroke-width:2px,color:#0D47A1;
    classDef php fill:#E8F5E9,stroke:#43A047,stroke-width:2px,color:#1B5E20;
    classDef database fill:#FFF3E0,stroke:#FB8C00,stroke-width:2px,color:#E65100;
    classDef security fill:#FCE4EC,stroke:#D81B60,stroke-width:2px,color:#880E4F;
    classDef session fill:#F3E5F5,stroke:#8E24AA,stroke-width:2px,color:#4A148C;


    %% Apply colors
    class Browser client;

    class login,dash,logout php;

    class PDO,verify security;

    class DB database;

    class session,uid,uname,terminate session;
```