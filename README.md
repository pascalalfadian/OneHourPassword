# One Hour Password

## Use Case

As a teacher, you want to upload your questions in PDF format to e-learning
platform so that student can only read the questions at the scheduled time and
not before. However, you don't want to overload the platform when the students
rush to download the PDF copies from the platform.

You can encrypt the PDF with a "randomly" generated password and send it to
your students beforehand. At the scheduled exam time, the student can retrieve
the password from `One Hour Password` web site by themselves without your help.

The `One Hour Password` website is designed with these considerations in mind:

1. Password retrieval is relatively cheap operation without any database connections, hence to avoid congestion when many students request at the same time.
2. The system is open for investigation, but secure without knowledge of the key; i.e. the [Kerckhoff's principle](https://en.wikipedia.org/wiki/Kerckhoffs%27s_principle).

## Installation Guide

You can use Heroku service for your own `One Hour Password` website. At the
time of this README writing, https://pascal.herokuapp.com can be used to play
around as a student.

1. Fork this project, if necessary
2. Register for Heroku account, if you do not have one (https://www.heroku.com)
3. Create a new app, with names and configurations of your choice. Free tier should be enough.
4. As for "Deployment method", choose GitHub and connect to GitHub repository of the `One Hour Password`. Choose manual or automatic deployment as per your preference.
5. In "Config Vars", add a new config variable as below:
	* KEY must be `password_secret_key`
	* VALUE be a string random characters with minimum of 32 characters. This must be kept secret.
6. Pray to God and access your heroku app URL (e.g. https://pascal.herokuapp.com). Ensure a random password is shown, and "key length" shows the length of your key set in previous steps (it must be greater than 0).

## Usage Guide

### As the teacher

For example, you have an exam at 17 August 1945, 10:00 to 12:00 (let's pretend we're living in the past, shall we?):

1. Go to `[your-herokuapp-url]/generate-get.php` [(example)](https://pascal.herokuapp.com/generate-get.php). For best result, use `https://` not `http://`)
2. Fill in the same key as you have set before, leave other options by it's default, then click "Get password".
3. You will get the password for current hour. Compare the password generated with the main URL [(example)](https://pascal.herokuapp.com). The password must be the same. Otherwise, the key you typed could be different (note: the system does not automatically compare the key, for security reason).
4. Click "repeat the process" to go back to the previous page.
5. Select "1945" as year, "8 - August" as Month, "17" as Day, and "10:00 to 10:59" as Hour. (note: the year part is be limited to &plusmn; 1 year from today)
6. You can see that the key is autosaved for you.
7. Click "Get password" again. You will get the passsword that will be visible to students on 17 August 1945, 10:00 to 10:59.
8. Use this password to encrypt the PDF. Tip: Make a copy for encrypted PDF (for example: `finalexam_encryped.pdf`) and keep the original version yourself.
9. Give the encrypted PDF and your main URL [(example)](https://pascal.herokuapp.com) to your students in advance before the exam.

### As the student

1. Get the encrypted PDF and wait for exam scheduled date/time.
2. At the exam date/time, visit the main URL and retrieve the password before the time expires.

## Notes & Caveats

1. It works on other formats too, as long as they can be easily encrypted and decrypted (ZIP and PDF are two good examples).
2. The generated password is only valid at given hour. If your exam starts at 10:30 for example, then **bummer, this is a limitation**. You must hence enable maintenance mode for your Heroku App before 10:00, and disable it manually at 10:30; and your students only have &plusmn; 30 minutes to retrieve the password.
3. If you use the free-tier of heroku, it will [sleep after 30 minutes of inactivity](https://www.heroku.com/pricing). Therefore, you may want to trigger the main URL 15 minutes before exam date/time to wake it up, so that the first student retrieving the password need not to wait. 
4. Regarding security:
    1. Do not give the encrypted PDF too soon (like, a month before). Clever student with good computing resource may guess the password with brute force technique.
    2. I just used gut feeling not exact calculation, but the complexity of cracking the password relies on minimum of these factors:
        1. **Generated password itself**: first 4 characters are predefined, while the rest 9 characters are valid base64 characters, i.e. 64<sup>9</sup> = 1.80 * 10<sup>16</sup> possibilities.
        2. **Your secret key**: assuming you use also random base64 characters, with minimum of 32 characters, i.e. 64<sup>32</sup> = 6.27 * 10<sup>57</sup> possibilities.
        3. **Size of your file**: in most cases it should be big enough. If at least 10 bytes of your file are completely random byte, i.e. 256<sup>10</sup> = 1.20 * 10<sup>24</sup> possibilities.
        4. **Strength of hash function**: SHA-256 is used, it should be enough.
    3. Let's say your computer can do 1 billion guess per second, it will take 10 million seconds (115 days) to crack the password.
    4. The original author earned Master degree in Infocomm Security, if that can help you feel safer using this.
