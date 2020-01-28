# empfohlen


# app_research
Empfohlen - App Research Project
Market research SRS version 1.0:
 
Concept:
    App research Company looking for testers, who are testing mobile applications and making reviews.
    Register for new user: Name, Surname, Email, Password
    Auto-Registermail send to all new user
    New users need to verify account with documents, then they get approved to see projects to test
   
    Our Member will get paid for testing and reviewing Apps.
    Every review has to be approved by the admins so that the user get paid.
    Based on research and data evaluation.
   
    ############################################################################################## 
User Panel:
    Balance (top right in the corner)
    Personal information
    Application Test (only shown for approved Tester)
    Review (only shown for approved Tester)
    Tickets (only shown for approved Tester)
   
    => Balance
    Balance indicator -> withdraw via ticket (maybe apply button) manually payout with paypal 
    --> Backend dashboard with all withdrawal requests and customer information
       Leaving a PayPal-adress and the payout will be proceed within 24h (working days)
    --> Backend dashboard view for withdrawal requests: Customer name, contact information (email/phone), 
       PayPal account, amount to pay, time requested payout
   
    => Personal information
    Editor for: Name, Surname, DOB, COB, Adress, ZIP, City, Phonenumber, Email, Work/Company, 
                Payment information (paypal/IBAN)
    + Attachments for applications --> document upload to verify user account
    Change Password option
   
    => Application Test
    User sees products which he can test and get paid for - products have an expiry date, product discription, required qualifications, pay
    When the product is expired the user cant accept that deal anymore --> Users should see a timer countdown for each project
    When the product is accepted by the user he will get into a Live Chat Queue and then can chat with one of the Support Advisor, who helps them to get though that process
 
    => Review
    User can write a review (1 to 5 star) and leave a Pro and Con Comments.
    Send button will send a request to the admin panel for payout.
    When it's approved by the admins he will get paid.
    --> Once the application test is finished the user needs to fill out a quiz to answer all questions and 
    he needs to have an optional upload function to upload pictures to support his statements. 
    Once the quiz is filled out and approved by support, he can see the balance in his account and request a payout.
 
    => Tickets (notification option)
    problem report - payment option - suggestions for improvement
   
   
Admin Panel:
    Users
    Products
    Reviews
    Withdraw Requests
    Auto-Mail
    Live Chat
    Tickets
--> Dashboard: Write down all daily management tasks that you want to put to dashboard --> User payout request list, quiz approval list, user management
 
    => Users
    5 User groups
    - Userlist with verification status (verified account, non verified account)
    - Can edit the Member and its informations and level (User, verified user, Company, Staff or Admin)
    User (newly registered and not approved)
    verified user(approved though application process)
    Company (approved though application process)
    Staff (can use admin dashboard panel and has only access to Live Chat option)
    Admin
   
    => Projects
    Can create new projects
    - countdown timer (days, hours, minutes, seconds)
    - product description editable
    - required qualification editable
    - pay editable
    - select member
 
    => Reviews
    Reviews from Members are shown in a list.
    When it's approved the pay will be added to the balance from the member.
    - 2-Step Approval
    1. Accept = User will get an additional introduction for payout. 
        Contract termination letter for the User to sign in.
    2. Approval = User will get paid after the quiz is answered, 
        all required documents are provided and the quiz was approved by support.
   
    => Withdraw Requests
    All withdraw requests are listed in here.
   
    => Auto-Mail
    Auto-mail function: for all new registered User a welcome message.
   
    => Live Chat
    All tester will get queued and the Staff can accept the Chat.
   
    => Ticket System
    Staff and Admin see all open and closed tickets
    Admin can open new ones for additional requirements or introductions for payout.
