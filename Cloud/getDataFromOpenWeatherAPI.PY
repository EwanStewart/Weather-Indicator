import requests
import json
from datetime import datetime
import boto3
from decimal import Decimal

api_key = "7fb6f480be9aa74e148e21d1edba622b"
lat = "56.461430"
lon = "-2.968110"
url = "https://api.openweathermap.org/data/2.5/onecall?lat=%s&lon=%s&appid=%s&units=metric" % (lat, lon, api_key)

def lambda_handler(event, context):
    dynamodb = boto3.client('dynamodb')
    response = requests.get(url)
    data = json.loads(response.text)


    #get current weather
    try:
        currentWeather = data["current"]["weather"][0]["main"]
        if currentWeather == "Rain":
            rainCurrently = 1
        else:
            rainCurrently = 0

        currentTemp = data["current"]["temp"]

        
        
        for i in range(0, 5):

            if data["hourly"][i]["weather"][0]["main"] == "Rain":

                rainSoon = 1
                break
            else:
                rainSoon = 0
                
        total = 0.0
        
        for i in range(0, 5):

            total += data["hourly"][i]["temp"]

        avgTemp = total / 5

        client = boto3.resource('dynamodb')
        table = client.Table("weatherData")
        #get date
        dt = datetime.now().strftime("%d%m%Y%H%M%S")


        table.put_item(Item= {'id': dt,'RainCurrently':  rainCurrently, 'RainSoon': rainSoon, 'TempCurrently': int(currentTemp), 'AvgTempFuture': int(avgTemp)})
        return "success"
    except Exception as e:
        return e





