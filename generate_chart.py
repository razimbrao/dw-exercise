import sqlite3
import pandas as pd
import matplotlib.pyplot as plt

db_path = "database/database.sqlite"

conn = sqlite3.connect(db_path)

def fetch_sales_data():
    query = """
        SELECT c.client, o.order_days AS date, SUM(d.total_amount) AS total_sales
        FROM daily_sales d
        JOIN clients c ON d.client_id = c.id
        JOIN order_days o ON d.order_date_id = o.id
        GROUP BY c.client, o.order_days
        ORDER BY o.order_days, c.client;
    """
    return pd.read_sql_query(query, conn)

def plot_total_sales_per_client(df):
    df_total_sales = df.groupby("client")["total_sales"].sum()

    df_total_sales.plot(kind="bar", figsize=(12, 6), color='skyblue')

    plt.xlabel("Cliente")
    plt.ylabel("Total Gasto")
    plt.title("Total Gasto por Cliente")
    plt.xticks(rotation=45)
    plt.grid(axis="y", linestyle="--", alpha=0.7)

    plt.savefig("charts/total_sales_per_client.png", dpi=300, bbox_inches="tight")
    plt.show()

def plot_daily_sales_per_client(df):
    df["date"] = pd.to_datetime(df["date"], format="%d/%m/%Y").dt.date

    df_pivot = df.pivot(index="date", columns="client", values="total_sales").fillna(0)

    df_pivot.plot(kind="bar", stacked=True, figsize=(12, 6), colormap="tab10")

    plt.xlabel("Data do Pedido")
    plt.ylabel("Total Gasto")
    plt.title("Gasto Diário por Cliente")
    plt.xticks(rotation=45)
    plt.legend(title="Clientes", bbox_to_anchor=(1.05, 1), loc="upper left")
    plt.grid(axis="y", linestyle="--", alpha=0.7)

    plt.savefig("charts/daily_sales_per_client.png", dpi=300, bbox_inches="tight")
    plt.show()

def generate_sales_chart():
    df = fetch_sales_data()
    if df.empty:
        print("Nenhum dado encontrado!")
        return

    plot_total_sales_per_client(df)
    plot_daily_sales_per_client(df)

generate_sales_chart()
