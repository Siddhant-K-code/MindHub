import connector
from connector import errorcode
import time
from datetime import datetime
from bs4 import BeautifulSoup as soup
from urllib.request import urlopen as uReq
import requests 
import pandas as pd

data_chk = {}
for i in range(5):


    my_url = 'https://photogallery.indiatimes.com/news'

    uNews = uReq(my_url)    
    page_html = uNews.read()
    uNews.close()

    page_soup = soup(page_html, "html.parser")



    containers = page_soup.findAll("div",{"class": "blk1"})
                                                      
    container = containers[0]
    l1 = container.a["href"]
    t1 = container.img["title"]



    containers = page_soup.findAll("div",{"class": "blk2"})
            
    container = containers[0]
    l2 = container.a["href"]
    t2 = container.img["title"]



    containers = page_soup.findAll("div",{"class": "blk22"})
             
    container = containers[0]
    l3 = container.a["href"]
    t3 = container.img["title"]


    containers = page_soup.findAll("div",{"class": "blk3"})
             
    container = containers[0]
    l4 = container.a["href"]
    t4 = container.img["title"]


    containers = page_soup.findAll("div",{"class": "blk24"})
             
    container = containers[0]
    l5 = container.a["href"]
    t5 = container.img["title"]


    containers = page_soup.findAll("div",{"class": "blk23"})
             
    container = containers[0]
    l6 = container.a["href"]
    t6 = container.img["title"]


    data = {t1:l1,t2:l2,t3:l3,t4:l4,t5:l5,t6:l6}
    
    if data != data_chk:
        data_chk = data
        try:
          cnx = connector.connect(user='root', database='mindhub')
        except connector.Error as err:
          if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
            print("Something is wrong with your user name or password")
          elif err.errno == errorcode.ER_BAD_DB_ERROR:
            print("Database does not exist")
          else:
            print(err)
        else:
          try:
            cursor = cnx.cursor()
            add_news = ("INSERT INTO news "
                           "(news_title, news_author, news_url, date_posted) "
                           "VALUES (%s, %s, %s, %s )")
            

            data_news = (t1, 'IndiaTimes', data[t1], datetime.now().date())
            cursor.execute(add_news, data_news)
            data_news = (t2, 'IndiaTimes', data[t2], datetime.now().date())
            cursor.execute(add_news, data_news)
            data_news = (t3, 'IndiaTimes', data[t3], datetime.now().date())
            cursor.execute(add_news, data_news)
            data_news = (t4, 'IndiaTimes', data[t4], datetime.now().date())
            cursor.execute(add_news, data_news)
            data_news = (t5, 'IndiaTimes', data[t5], datetime.now().date())
            cursor.execute(add_news, data_news)
            data_news = (t6, 'IndiaTimes', data[t6], datetime.now().date())
            cursor.execute(add_news, data_news)

            # Insert new news
                        
            # Make sure data is committed to the database
            cnx.commit()

            cursor.close()
          except:
            pass
          
        print('Job, well done')
        cnx.close()

    time.sleep(300)

    
    
