define({ "api": [
  {
    "description": "<p>all User access</p> <p>This optional description for this api block.</p>",
    "type": "get",
    "url": "/v1/sample",
    "title": "Test Default Request",
    "name": "SampleDefault",
    "group": "Sample",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "action",
            "description": "<p>Action name.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"action\":\"index\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": " HTTP/1.1 405 Method Not Allowed\n{\n  \"name\": \"Method Not Allowed\",\n  \"message\": \"Method Not Allowed. This url can only handle the following request methods: GET.\",\n  \"code\": 0,\n  \"status\": 405,\n  \"type\": \"yii\\\\web\\\\MethodNotAllowedHttpException\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "modules/api/v1/controllers/SampleController.php",
    "groupTitle": "Sample"
  }
] });
