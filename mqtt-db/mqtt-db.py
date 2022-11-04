#!/usr/bin/env python3
import paho.mqtt.client as mqtt
import mysql.connector
from mysql.connector import Error
import ssl
import logging
import json

logging.basicConfig(level=logging.DEBUG)

user = "mqttzappeu"
password = "Eur0mqz@081"


def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))
    client.subscribe("argus/report/#")

# def publish_To_Topic(topic, message):
#	mqttc.publish(topic,message)
#	print ("Published: " + str(message) + " " + "on MQTT Topic: " + str(topic))
#	print ("")

#
# Insert data from MQTT to MySQL table
#

def insertDataToMySql(utcid, hubid, sensoridval, sensortypeval, valueval, unitval):
    try:
        connection = mysql.connector.connect(host='localhost',
                                            database='mqttdata',
                                            user='payloader',
                                            password='wY#UcYxpo659$6jzsHg')
        if connection.is_connected():
            db_Info = connection.get_server_info()
            print("Connected to MySQL Server version ", db_Info)
            cursor = connection.cursor()
            sql = "INSERT INTO dbo_payloader (utc,hub,sensor_id,sensor_type,value,unit) VALUES (%s,%s,%s,%s,%s,%s)"
            val = (utcid, hubid, sensoridval, sensortypeval, valueval, unitval)
            print(val)
            cursor.execute(sql, val)
            connection.commit()
            print(cursor.rowcount, "record inserted.")

    except Error as e:
        print("Error while connecting to MySQL", e)

    finally:
        if (connection.is_connected()):
            cursor.close()
            connection.close()
            print("MySQL connection is closed")


def on_message(client, userdata, msg):
    #    print("received Data "+msg)
    #    y=json.loads(msg)
    #    print("After json.loads")

    m_decode = str(msg.payload.decode("utf-8", "ignore"))
    print("data Received type", type(m_decode))
    print("data Received", m_decode)
    #print("Topic=", msg.topic)
    print("Converting from Json to Object")
    y = json.loads(m_decode)  # decode json data
    print(type(y))
    utcval = str(y["UTC"])
    hubval = str(msg.topic)
    sensoridval = str(y["SensorId"])
    sensortypeval = str(y["SensorType"])
    valueval = str(y["Value"])
    unitval = str(y["Units"])
    # print(hubval)
    hubid = hubval.replace('argus/report/', '')
    print(hubid)
    utcid=utcval.replace(',',' ')
    insertDataToMySql(utcid, hubid, sensoridval, sensortypeval, valueval, unitval)
    

#insertDataToMySql("test" , "test" , "test", "test", "test", "test")

client = mqtt.Client()
logger = logging.getLogger(__name__)
client.enable_logger(logger)

client.tls_set(ca_certs="/etc/ssl/certs/DST_Root_CA_X3.pem",
               tls_version=ssl.PROTOCOL_TLSv1_2)
client.username_pw_set(user, password=password)
client.connect("mqtt.eurozapp.eu", 8883, 60)

client.on_connect = on_connect
client.on_message = on_message

client.loop_forever()
