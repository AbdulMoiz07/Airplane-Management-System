from tkinter import ttk, messagebox, StringVar, NO, CENTER, END
import customtkinter
import sqlite3

# Database setup
def setup_database():
    conn = sqlite3.connect("Ticket_Reservation_System.db")
    cursor = conn.cursor()
    cursor.execute("DROP TABLE IF EXISTS Ticket")
    conn.execute('''
    CREATE TABLE Ticket(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        movie_name TEXT,
        Number_of_tickets INTEGER,
        Price INTEGER
    )
    ''')
    conn.commit()
    conn.close()

def insert_tickets():
    conn = sqlite3.connect("Ticket_Reservation_System.db")
    cursor = conn.cursor()
    tickets_data = [
        ('Movie# 1', 10, 50),
        ('Movie# 2', 5, 30),
        ('Movie# 3', 12, 70),
        ('Movie# 4', 15, 20),
        ('Movie# 5', 10, 25)
    ]
    cursor.executemany('INSERT INTO Ticket(movie_name, Number_of_tickets, Price) VALUES (?, ?, ?)', tickets_data)
    conn.commit()
    conn.close()

def get_tickets():
    conn = sqlite3.connect("Ticket_Reservation_System.db")
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM Ticket")
    tickets = cursor.fetchall()
    conn.close()
    return tickets

def update_quantity(ticket_id, reserved_quantity):
    conn = sqlite3.connect("Ticket_Reservation_System.db")
    cursor = conn.cursor()
    cursor.execute('UPDATE Ticket SET Number_of_tickets = Number_of_tickets - ? WHERE id = ?', (reserved_quantity, ticket_id))
    conn.commit()
    conn.close()

# Initialize the app
app = customtkinter.CTk()
app.title("TICKET RESERVATION SYSTEM")

# Set the geometry of the window
app.geometry("1350x700+0+0")  # Width x Height

# Optional: To set the position of the window, you can use:
# app.geometry("600x600+100+50")  # Width x Height + X_offset + Y_offset

app.config(bg='#18161D')
app.resizable(False, False)

# Define fonts
font1 = ('Arial', 25, 'bold')
font2 = ('Arial', 13, 'bold')
font3 = ('Arial', 18, 'bold')

def add_to_treeview():
    tickets = get_tickets()
    tree.delete(*tree.get_children())  # Clear existing data
    for ticket in tickets:
        if ticket[2] > 0:  # ticket[2] is the Number_of_tickets column
            tree.insert('', END, values=ticket)

# Title label
title1_label = customtkinter.CTkLabel(app, font=font1, text="AVAILABLE MOVIES", text_color='#fff')
title1_label.place(x=150, y=20)

# Label for name entry
name_label = customtkinter.CTkLabel(app, font=font3, text="CUSTOMER NAME", text_color='black')
name_label.place(x=50, y=450)

# Entry for name
name_entry = customtkinter.CTkEntry(app, font=font1, text_color='#000', fg_color='#fff', border_color='#AA04A7', border_width=2, width=300)
name_entry.place(x=250, y=450)

# Label for book number of tickets
book_number_label = customtkinter.CTkLabel(app, font=font3, text="BOOK TICKETS", text_color='black')
book_number_label.place(x=50, y=500)

# Dropdown variable and options
variable1 = StringVar()
options = ['1', '2', '3']

# Create ComboBox for options
duration_options = customtkinter.CTkComboBox(app, font=font3, text_color='#000', fg_color='#fff', dropdown_hover_color='#AA04A7', button_color='#AA04A7', button_hover_color='#AA04A7', width=300, variable=variable1, values=options, state='readonly')
duration_options.set('1')
duration_options.place(x=250, y=500)

# Treeview for displaying available tickets
style = ttk.Style(app)
style.theme_use('clam')
style.configure('Treeview', font=font2, foreground='#fff', background='#292933', fieldbackground='#292933')
style.map('Treeview', background=[('selected', '#AA04A7')])

tree = ttk.Treeview(app, height=8)
tree['columns'] = ('Ticket ID', 'Movie Name', 'Available Tickets', 'Ticket Price')
tree.column('#0', width=0, stretch=NO)
tree.column('Ticket ID', anchor=CENTER, width=100)
tree.column('Movie Name', anchor=CENTER, width=150)
tree.column('Available Tickets', anchor=CENTER, width=150)
tree.column('Ticket Price', anchor=CENTER, width=100)

tree.heading('Ticket ID', text='Ticket ID')
tree.heading('Movie Name', text='Movie Name')
tree.heading('Available Tickets', text='Available Tickets')
tree.heading('Ticket Price', text='Ticket Price')

tree.place(x=50, y=100)

# Function to handle ticket booking
def book_ticket(name, option):
    if name:
        selected_item = tree.selection()
        if selected_item:
            item = tree.item(selected_item)
            ticket_id = item['values'][0]
            available_tickets = item['values'][2]
            reserved_quantity = int(option)
            if reserved_quantity <= available_tickets:
                update_quantity(ticket_id, reserved_quantity)
                add_to_treeview()
                messagebox.showinfo("Booking Confirmation", f"Ticket booked for {name} for {reserved_quantity} tickets.")
            else:
                messagebox.showerror("Quantity Error", "Not enough tickets available.")
        else:
            messagebox.showerror("Selection Error", "Please select a movie.")
    else:
        messagebox.showerror("Input Error", "Please enter your name.")

# Button to book tickets
book_button = customtkinter.CTkButton(app, cursor='hand2', text="Book Tickets", font=font3, text_color='#000', fg_color='#AA04A7', hover_color='#AA04A7', command=lambda: book_ticket(name_entry.get(), variable1.get()))
book_button.place(x=250, y=550)

# Initialize database and insert data
setup_database()
insert_tickets()
add_to_treeview()

# Run the app
app.mainloop()